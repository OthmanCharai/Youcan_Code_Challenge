<?php

namespace App\Repositories;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ProductRepositoryProvider extends ServiceProvider implements DeferrableProvider
{

    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, fn() => new ProductRepository());
    }

    public function provides()
    {
        return [ProductRepositoryInterface::class];
    }

}
