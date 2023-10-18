<?php

namespace App\Console\Commands;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Category;
use App\Repositories\Categories\CategoryRepositoryInterface;
use App\Repositories\Products\ProductRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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


    protected ProductRepositoryInterface $productRepository;

    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(
        ProductRepositoryInterface  $productRepository,
        CategoryRepositoryInterface $categoryRepository
    )
    {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws ValidationException
     */
    public function handle(): int
    {
        // Get or Create a new Category
        $category = $this->handleCategoryCreation();

        //Create a new Product
        $this->handleProductCreation($category->id);

        return 1;
    }

    /**
     * handleCategoryCreation Creation and display
     * @return Category
     * @throws ValidationException
     */
    private function handleCategoryCreation(): Category
    {
        // Display a list of categories for the user to choose from
        $categories = $this->categoryRepository->getAllCategories();
        $this->info('Available Categories:');
        $this->table(
            ['Id', 'Parent Category Id', 'Name', 'Created At', 'Updated At'],
            $categories->toArray()
        );

        $categoryID = $this->ask('Enter the ID of the selected category or enter "new" to create a new category');

        if ($categoryID === 'new') {

            $categoryData = [
                'name' => $this->ask('Enter the name of the new category')
            ];

            $categoryValidator = Validator::make($categoryData, (new CategoryStoreRequest())->rules());

            $this->showErrorMessage($categoryValidator);

            $categoryValidatedData = $categoryValidator->validated();

            $this->info('New category created successfully.');

            return $this->categoryRepository->storeCategory($categoryValidatedData);
        }

        try {

            return $this->categoryRepository->findById($categoryID);

        } catch (ModelNotFoundException $exception) {

            $this->info($exception->getMessage());

            exit(1);
        }

    }


    /**
     * @param int $categoryId
     * @return void
     * @throws ValidationException
     */
    private function handleProductCreation(int $categoryId)
    {

        $productData = [
            'name' => $this->ask('Enter the product name'),
            'description' => $this->ask('Enter the product description'),
            'price' => $this->ask('Enter the product price, should be numeric please'),
            'image' => $this->checkFileExist(
                $this->ask('Enter the product image path: image should be in storage/app/path to your file')
            ),
            'category_id' => $categoryId
        ];

        $productValidator = Validator::make($productData, (new ProductStoreRequest())->rules());

        $this->showErrorMessage($productValidator);

        $validatedData = $productValidator->validated();

        $this->productRepository->storeProduct($validatedData);

        $this->info("Product created successfully!");

    }

    /**
     * @param $validator
     * @return void
     */
    private function showErrorMessage($validator)
    {
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            exit(1);
        }
    }

    /**
     * @param string $path
     * @return string|void
     */
    private function checkFileExist(string $path)
    {
        if (!Storage::exists($path)) {
            $this->info('file does note exists in storage/app folder');
            exit(1);
        }
        return $path;
    }
}
