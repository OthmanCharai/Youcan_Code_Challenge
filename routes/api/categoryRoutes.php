<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'category'
    ],
    function () {

        Route::get('/', CategoryController::class)->name('category.index');
    }
);
