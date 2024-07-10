<?php

namespace App\Http\Controllers;

use App\Models\Product;

// Requests
use App\Http\Requests\Product\ProductIndex;
use App\Http\Requests\Product\ProductUpdate;
use App\Http\Requests\Product\ProductStore;

use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductIndex $request)
    {
        $cacheKey = 'products_' . $request->input('top', 0) . '_' . $request->input('sort', 'asc') . '_' . $request->input('sortBy', 'top') . '_' . $request->input('page', 1);

        if(Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        } else {
            return Cache::rememberForever($cacheKey, function () use ($request) {
                // Added products table prefix to avoid ambiguity when joining tables
                $products = Product::select(['products.uuid','products.name','products.description','products.price'])
                                ->where('products.top', $request->input('top', 0));

                // Paginate products
                $sort = $request->input('sort', 'asc');
                $sortBy = $request->input('sortBy', 'name');

                $sortMapping = [
                    'name' => 'products.name',
                    'price' => 'products.price',
                    'category' => 'categories.name'
                ];

                if($sortBy === 'category') {
                    $products = $products
                                    ->join('category_product', 'products.uuid', '=', 'category_product.product_uuid')
                                    ->join('categories', 'category_product.category_uuid', '=', 'categories.uuid');
                }

                $products = $products
                                ->orderBy($sortMapping[$sortBy], $sort)
                                ->simplePaginate(config('app.pagination'));

                return response()->json($products);
            });
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStore $request)
    {
        try {
            $validatedData = $request->validated();

            $product = new Product(Arr::except($validatedData, ['category']));
            $product->save();

            $product->categories()->attach($validatedData['categories']);

            return response()->json($product);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);

            return response()->json($product);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdate $request, $id)
    {
        try {
            $validatedData = $request->validated();

            $product = Product::findOrFail($id);
            $product->fill(Arr::except($validatedData, ['category']));
            $product->save();

            $product->categories()->sync($validatedData['categories']);

            return response()->json($product);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json(['message' => 'Product deleted successfully!']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
