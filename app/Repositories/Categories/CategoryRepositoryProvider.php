<?php

namespace App\Repositories\Categories;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CategoryRepositoryProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, fn() => new CategoryRepository());
    }

    /**
     * @return string[]
     */
    public function provides(): array
    {
        return [CategoryRepositoryInterface::class];
    }

}
