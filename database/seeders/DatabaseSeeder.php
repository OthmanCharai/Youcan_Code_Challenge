<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()
            ->count(5)
            ->create();

        $categories = Category::all();
        $category = $categories->first();

        Category::factory()->create([
            'parent_id' => $category->id
        ]);

        $categories->each(function ($item) {
            $item->products()->attach($product = Product::factory()->create());
        });

    }
}
