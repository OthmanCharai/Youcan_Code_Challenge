<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Repositories\Categories\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     *
     * @param Request $request
     * @return CategoryCollection
     */
    public function __invoke(Request $request): CategoryCollection
    {
        $categories=$this->categoryRepository->getAllCategories();

        return new CategoryCollection($categories);
    }
}
