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
        $categoryID = $this->ask('Enter the ID of the selected category or enter "new" to create a new category');

        if ($categoryID === 'new') {
            // If the user wants to create a new category
            $categoryName = $this->ask('Enter the name of the new category');
            $newCategory = Category::create(['name' => $categoryName]);
            $categoryID = $newCategory->id;
            $this->info('New category created successfully.');
        } else {
            // Check if the selected category exists
            $selectedCategory = Category::find($categoryID);

            if (!$selectedCategory) {
                $this->error('Category not found. Please provide a valid category ID or "new" to create a new category.');
                return 0;
            }
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
