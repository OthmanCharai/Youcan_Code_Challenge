<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{

    /**
     * @param array $data
     * @return mixed
     */
    public function storeProduct(array $data)
    {
        $product = Product::create($data);
        $product->categories()->syncwithoutdetaching($data['category_id']);
        return $product;
    }

    /**
     * @param float $maxPriceRange
     * @param int|null $categoryId
     * @return Builder[]|Collection
     */

    public function getAllProducts(float $maxPriceRange = 0, int $categoryId = null)
    {
        $query = Product::with('categories');

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        if ($maxPriceRange > 0) {
            $query->where('price', '<=', $maxPriceRange);
        }

        return $query->get();
    }

}
