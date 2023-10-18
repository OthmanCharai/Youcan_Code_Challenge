<?php

namespace App\Repositories\Products;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    /**
     * @param array $data
     * @return Product
     */
    public function storeProduct(array $data): Product;

    /**
     * @param float $maxPriceRange
     * @param int $categoryId
     * @return mixed
     */
    public function getAllProducts(float $maxPriceRange, int $categoryId): Collection;


}
