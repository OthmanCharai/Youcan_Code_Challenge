<?php

namespace App\Repositories\Categories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{


    /**
     * @return Category[]|Collection
     */
    public function getAllCategories()
    {
        return Category::all();
    }

}
