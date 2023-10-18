<?php

namespace App\Repositories\Products;

interface ProductRepositoryInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function storeProduct(array $data);

    /**
     * @param float $maxPriceRange
     * @param int $categoryId
     * @return mixed
     */
    public function getAllProducts(float $maxPriceRange, int $categoryId);


}
