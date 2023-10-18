<?php

namespace App\Repositories\Categories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{

    /**
     * @return Category[]|Collection
     */
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    /**
     * @param int $id
     * @return Category
     */
    public function findById(int $id): Category
    {
        return Category::findOrFail($id);
    }

    /**
     * @param array $data
     * @return Category
     */
    public function storeCategory(array $data): Category
    {
        return Category::create($data);
    }
}
