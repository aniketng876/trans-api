<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Creating 2 Parent Categories
        $parent1 = Category::create(['name' => 'Electronics']);
        $parent2 = Category::create(['name' => 'Home Appliances']);

        // Creating 3 Child Categories
        $child1 = Category::create(['name' => 'Mobile Phones', 'parent_category_id' => $parent1->id]);
        $child2 = Category::create(['name' => 'Laptops', 'parent_category_id' => $parent1->id]);
        $child3 = Category::create(['name' => 'Kitchen Appliances', 'parent_category_id' => $parent2->id]);
    }
}
