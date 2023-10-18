<?php

namespace App\Http\Controllers;

use App\Exceptions\UploadImageException;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Repositories\Products\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param Request $request
     * @return ProductCollection
     */
    public function index(Request $request): ProductCollection
    {
        $categoryId = $request->input('category', null);
        $maxPriceRange = $request->input('price', 0);


        $products = $this->productRepository
            ->getAllProducts($maxPriceRange,  ($categoryId !== "null") ? $categoryId : null);

        return new ProductCollection($products);
    }

    /**
     * @param ProductStoreRequest $request
     * @return ProductResource
     * @throws UploadImageException
     */
    public function store(ProductStoreRequest $request): ProductResource
    {
        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = Storage::put('products', $file);
                $url=Storage::url($path);
            }
        } catch (\Exception $exception) {
            throw new UploadImageException(
                $exception->getCode(),
                $exception
            );
        }

        $product = $this->productRepository->storeProduct(array_merge($request->validated(), ['image' => $url]));

        return new ProductResource($product);
    }

}
