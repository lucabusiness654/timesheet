<?php

// app/Services/ProductSearchService.php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductSearchService
{
    public function search(
        ?string $query = null,
        array $filters = [],
        ?float $minPrice = null,
        ?float $maxPrice = null,
        int $perPage = 24,
        string $sortBy = 'relevance'
    ) {
        $products = Product::query()
            ->when($query, function ($q) use ($query) {
                $q->whereFullText(['name', 'description'], $query);
            })
            ->when($minPrice || $maxPrice, function ($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('effective_price', [
                    $minPrice ?? 0,
                    $maxPrice ?? PHP_INT_MAX
                ]);
            })
            ->when(!empty($filters), function ($q) use ($filters) {
                foreach ($filters as $type => $values) {
                    $q->whereHas('filters', function ($subQ) use ($type, $values) {
                        $subQ->where('filter_type', $type)
                            ->whereIn('filter_value', (array)$values);
                    });
                }
            });

        // Sorting
        $products = match ($sortBy) {
            'price_asc' => $products->orderBy('effective_price'),
            'price_desc' => $products->orderByDesc('effective_price'),
            'newest' => $products->orderByDesc('created_at'),
            'bestseller' => $products->orderByDesc('is_bestseller'),
            default => $query ? $products->orderByRaw('MATCH(name, description) AGAINST(? IN BOOLEAN MODE) DESC', [$query])
                             : $products->orderByDesc('created_at'),
        };

        return $products->paginate($perPage);
    }

    public function getFacetCounts(?string $query = null, array $appliedFilters = []): array
    {
        $cacheKey = $this->buildFacetCacheKey($query, $appliedFilters);
        
        return Cache::remember($cacheKey, now()->addHours(1), function () use ($query, $appliedFilters) {
            // Base query for products matching search and current filters
            $baseQuery = Product::query()
                ->when($query, function ($q) use ($query) {
                    $q->whereFullText(['name', 'description'], $query);
                })
                ->when(!empty($appliedFilters), function ($q) use ($appliedFilters) {
                    foreach ($appliedFilters as $type => $values) {
                        $q->whereHas('filters', function ($subQ) use ($type, $values) {
                            $subQ->where('filter_type', $type)
                                ->whereIn('filter_value', (array)$values);
                        });
                    }
                });

            // Get counts for all filters
            $filterCounts = DB::table('product_filters')
                ->select('filter_type', 'filter_value', DB::raw('COUNT(*) as count'))
                ->whereIn('product_item_id', $baseQuery->select('product_item_id'))
                ->groupBy('filter_type', 'filter_value')
                ->get()
                ->groupBy('filter_type');

            return [
                'filters' => $filterCounts,
                'price_range' => [
                    'min' => $baseQuery->min('effective_price'),
                    'max' => $baseQuery->max('effective_price'),
                ]
            ];
        });
    }

    protected function buildFacetCacheKey(?string $query, array $appliedFilters): string
    {
        $filterKey = collect($appliedFilters)
            ->map(fn($values, $type) => $type . '=' . implode(',', (array)$values))
            ->sort()
            ->implode('|');

        return 'facets:' . md5($query ?? '') . ':' . md5($filterKey);
    }
}