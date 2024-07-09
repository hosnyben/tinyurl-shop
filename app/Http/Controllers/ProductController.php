<?php

namespace App\Http\Controllers;

use App\Models\Product;

// Requests
use App\Http\Requests\Product\ProductIndex;
use App\Http\Requests\Product\ProductUpdate;
use App\Http\Requests\Product\ProductStore;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductIndex $request)
    {
        // Paginate products
        $products = Product::where('top', $request->input('top', 0))->simplePaginate(config('app.pagination'));

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStore $request)
    {
        try {
            $product = new Product($request->validated());
            $product->save();

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
            $product = Product::findOrFail($id);
            $product->fill($request->validated());
            $product->save();

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
