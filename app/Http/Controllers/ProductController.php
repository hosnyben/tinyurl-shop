<?php

namespace App\Http\Controllers;

use App\Models\Product;

// Requests
use App\Http\Requests\Product\ProductIndex;
use App\Http\Requests\Product\ProductUpdate;
use App\Http\Requests\Product\ProductStore;

use Illuminate\Support\Arr;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/products",
     *     operationId="products.index",
     *     tags={"Products"},
     *     summary="List products",
     *     description="List products endpoint",
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         description="Sort order"
     *     ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         description="Field to sort by"
     *     ),
     *     @OA\Parameter(
     *         name="top",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="Number of top results to return"
     *     ),
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         description="Category filter"
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="Page number"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Error processing the request",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     )
     * )
     */
    public function index(ProductIndex $request)
    {
        $cacheKey = 'products_' . $request->input('top', 0) . '_' . $request->input('sort', 'asc') . '_' . $request->input('sortBy', 'top') . '_cat' . $request->input('category', 'none') . '_' . $request->input('page', 1);

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

                if( $sortBy === 'category' || $request->has('category')) {
                    $products = $products
                                    ->join('category_product', 'products.uuid', '=', 'category_product.product_uuid')
                                    ->join('categories', 'category_product.category_uuid', '=', 'categories.uuid');
    
                    if( $request->has('category') ) {
                        $products = $products->where('categories.uuid', $request->input('category'));
                    }
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
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/products/",
     *     operationId="product.create",
     *     tags={"Products"},
     *     summary="Create product",
     *     description="Create product endpoint",
     *     @OA\RequestBody(
     *         request="CreateProduct",
     *         description="Create product request body",
     *         required=true,
     * 
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name","description","price","top","categories"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="The product name",
     *                     default=""
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="The description of the product",
     *                     default=""
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="string",
     *                     description="The price of the product",
     *                     default=""
     *                 ),
     *                 @OA\Property(
     *                     property="top",
     *                     type="boolean",
     *                     description="The price of the product",
     *                     default="false"
     *                 ),
     *                 @OA\Property(
     *                     property="categories",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string"
     *                     ),
     *                     description="Array of categories UUID",
     *                     default="[]"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Error processing the request",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     )
     * )
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
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/products/{uuid}",
     *     operationId="product.show",
     *     tags={"Products"},
     *     summary="Show product",
     *     description="Show product endpoint",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="Product uuid",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Error processing the request",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     )
     * )
     */
    public function show(Request $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $cookieKeys = md5('last_viewed_products');

            $lastViewedProducts = json_decode($request->cookie($cookieKeys, '[]'),true);
    
            if (!in_array($id, $lastViewedProducts)) {
                array_unshift($lastViewedProducts, $id);
            }
        
            $lastViewedProducts = array_unique($lastViewedProducts);
            $lastViewedProducts = array_slice($lastViewedProducts, 0, 10);

            $cookie = cookie($cookieKeys, json_encode($lastViewedProducts), 60 * 24 * 30); // Cookie valid for 30 days

            return response()->json($product)->withCookie($cookie);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Patch(
     *     path="/api/products/{uuid}",
     *     operationId="product.update",
     *     tags={"Products"},
     *     summary="Update product",
     *     description="Update product endpoint",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="Product uuid",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         request="UpdateProduct",
     *         description="Update product request body",
     *         required=true,
     * 
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name","description","price","top","categories"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="The product name",
     *                     default=""
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="The description of the product",
     *                     default=""
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="string",
     *                     description="The price of the product",
     *                     default=""
     *                 ),
     *                 @OA\Property(
     *                     property="top",
     *                     type="boolean",
     *                     description="The price of the product",
     *                     default="false"
     *                 ),
     *                 @OA\Property(
     *                     property="categories",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string"
     *                     ),
     *                     description="Array of categories UUID",
     *                     default="[]"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Error processing the request",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     )
     * )
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
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *     path="/api/products/{uuid}",
     *     operationId="product.destroy",
     *     tags={"Products"},
     *     summary="Update product",
     *     description="Create product endpoint",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="Product uuid",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Error processing the request",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     )
     * )
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

    /**
     * Get the last viewed products
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/last-viewed-products",
     *     operationId="products.lastviewed",
     *     tags={"Products"},
     *     summary="List last viwed products",
     *     description="List last viwed products endpoint",
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Error processing the request",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     )
     * )
     */
    public function lastViewedProducts(Request $request)
    {
        $cookieKeys = md5('last_viewed_products');
        $lastViewedProducts = json_decode($request->cookie($cookieKeys, '[]'),true);

        $products = Product::whereIn('uuid', $lastViewedProducts)->get()->toArray();

        $sortedProducts = [];
        foreach ($lastViewedProducts as $key => $value) {
            $sortedProducts[] = $products[array_search($value, array_column($products, 'uuid'))];
        }

        return response()->json($sortedProducts);
    }
}
