<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // Display a list of categories for the user to choose from
        $categories = Category::all(['id', 'name']);
        $this->info("Select a category to create a product:");

        foreach ($categories as $category) {
            $this->line("{$category->id}: {$category->name}");
        }

        $categoryID = $this->ask('Enter the ID of the selected category');

        // Check if the selected category exists
        $selectedCategory = Category::find($categoryID);

        if (!$selectedCategory) {
            $this->error('Category not found. Please provide a valid category ID.');
            return 0;
        }

        // Ask the user for product information
        $productName = $this->ask('Enter the product name');
        $productDescription = $this->ask('Enter the product description');
        $productPrice = $this->ask('Enter the product price');
        $productImageUrl = $this->ask('Enter the product image path: image should be in storage/app/path to your file');

        // Create the product
        $product = new Product([
            'name' => $productName,
            'description' => $productDescription,
            'price' => $productPrice,
            'image' => storage_path($productImageUrl),
        ]);

        // Associate the product with the selected category
        $selectedCategory->products()->save($product);

        $this->info('Product created successfully!');
        return 1;
    }
}
