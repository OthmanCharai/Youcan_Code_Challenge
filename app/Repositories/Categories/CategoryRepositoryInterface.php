<?php

namespace App\Repositories\Categories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{

    /**
     * Get All Categories
     */
    public function getAllCategories(): Collection;


    /**
     * @param int $id
     * @return Category
     */
    public function findById(int $id): Category;

    /**
     * @param array $data
     * @return Category
     */
    public function storeCategory(array $data): Category;
}
