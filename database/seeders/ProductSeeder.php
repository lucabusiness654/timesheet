<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $colors = ['red', 'blue', 'green', 'black', 'white'];
        $categories = ['men', 'women', 'kids'];
        $subCategories = ['shirts', 'pants', 'dresses', 'jackets'];
        $materials = ['cotton', 'polyester', 'linen', 'denim'];
        $styles = ['casual', 'formal', 'party', 'sport'];
        $sizes = ['s', 'm', 'l', 'xl'];

        for ($i = 1; $i <= 20; $i++) {
            $color = $colors[array_rand($colors)];
            $category = $categories[array_rand($categories)];
            $subCategory = $subCategories[array_rand($subCategories)];
            $material = $materials[array_rand($materials)];
            $style = $styles[array_rand($styles)];

            $name = ucfirst($category) . ' ' . ucfirst($style) . ' ' . ucfirst($subCategory);
            $sku = strtoupper(substr($subCategory, 0, 3)) . '-' . strtoupper($color) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $named_link = Str::slug($name);
            $price = rand(500, 2000);
            $discount = rand(50, 500);
            $effective_price = $price - $discount;
            $percent = round(($discount / $price) * 100, 2);

            $product = Product::create([
                'product_item_id' => 'prod_' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'product_id' => 'prod_' . $i,
                'sku' => $sku,
                'name' => $name,
                'description' => 'A stylish ' . $style . ' ' . $subCategory . ' made from quality ' . $material . '.',
                'named_link' => $named_link,
                'link' => '/products/' . $named_link . '-' . $i,
                'price' => $price,
                'effective_price' => $effective_price,
                'discount_price' => $discount,
                'discount' => $discount,
                'effective_discount_percent' => $percent,
                'stock_status' => rand(0, 1),
                'is_bestseller' => rand(0, 1),
                'is_recommend' => rand(0, 1),
                'image' => '/images/' . $subCategory . '-' . $color . '.jpg',
                'delivery_day' => rand(1, 7),
                'created_at' => now()->subDays(rand(1, 30)),
            ]);

            // Attach filters
            $product->filters()->createMany([
                ['filter_type' => 'color', 'filter_value' => $color],
                ['filter_type' => 'category', 'filter_value' => $category],
                ['filter_type' => 'category', 'filter_value' => $subCategory],
                ['filter_type' => 'material', 'filter_value' => $material],
                ['filter_type' => 'style', 'filter_value' => $style],
            ]);

            // Add multiple sizes randomly
            $selectedSizes = array_rand(array_flip($sizes), rand(1, count($sizes)));
            if (!is_array($selectedSizes)) {
                $selectedSizes = [$selectedSizes];
            }

            foreach ($selectedSizes as $size) {
                $product->filters()->create([
                    'filter_type' => 'size_top',
                    'filter_value' => $size,
                ]);
            }
        }
    }
}
