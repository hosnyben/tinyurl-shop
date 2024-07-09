<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

// CRUD routes for products
Route::apiResource('products', ProductController::class);
