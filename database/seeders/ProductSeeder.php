<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Get categories
        $parentCategories = Category::whereNull('parent_category_id')->pluck('id')->toArray();
        $childCategories = Category::whereNotNull('parent_category_id')->pluck('id')->toArray();

        // Create 15 products in Parent Categories
        for ($i = 0; $i < 15; $i++) {
            Product::create([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'sku' => $faker->unique()->uuid,
                'price' => $faker->randomFloat(2, 100, 1000),
                'category_id' => $faker->randomElement($parentCategories),
            ]);
        }

        // Create 35 products in Child Categories
        for ($i = 0; $i < 35; $i++) {
            Product::create([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'sku' => $faker->unique()->uuid,
                'price' => $faker->randomFloat(2, 100, 1000),
                'category_id' => $faker->randomElement($childCategories),
            ]);
        }
    }
}
