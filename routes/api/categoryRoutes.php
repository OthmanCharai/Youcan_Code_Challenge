<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'category'
    ],
    function () {
        Route::get('/', [ProductController::class, 'getAllCategories'])->name('category.index');

    }
);
