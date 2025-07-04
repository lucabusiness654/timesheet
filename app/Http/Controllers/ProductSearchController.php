<?php

namespace App\Http\Controllers;

use App\Services\ProductSearchService;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function __construct(protected ProductSearchService $searchService) 
    {
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'q' => 'nullable|string|max:255',
            'filters' => 'nullable|array',
            'filters.*' => 'array',
            'filters.*.*' => 'string',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
            'sort' => 'nullable|in:relevance,price_asc,price_desc,newest,bestseller',
            'page' => 'nullable|integer|min:1',
        ]);

        $results = $this->searchService->search(
            query: $validated['q'] ?? null,
            filters: $validated['filters'] ?? [],
            minPrice: $validated['price_min'] ?? null,
            maxPrice: $validated['price_max'] ?? null,
            sortBy: $validated['sort'] ?? 'relevance'
        );

        $facets = $this->searchService->getFacetCounts(
            query: $validated['q'] ?? null,
            appliedFilters: $validated['filters'] ?? []
        );

        return response()->json([
            'products' => $results,
            'facets' => $facets,
        ]);
    }
}