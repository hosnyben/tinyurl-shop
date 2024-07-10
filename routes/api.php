<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// CRUD routes for products
Route::apiResource('products', ProductController::class);
Route::get('last-viewed-products', [ProductController::class, 'lastViewedProducts']);

// CRUD routes for categories
Route::apiResource('categories', CategoryController::class);
