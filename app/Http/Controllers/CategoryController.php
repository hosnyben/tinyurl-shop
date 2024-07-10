<?php

namespace App\Http\Controllers;

use App\Models\Category;

// Requests
use App\Http\Requests\Category\CategoryStore;
use App\Http\Requests\Category\CategoryUpdate;

use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/categories",
     *     operationId="categories.index",
     *     tags={"Categories"},
     *     summary="List categories",
     *     description="List categories endpoint",
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
    public function index()
    {
        $cacheKey = 'categories_' . request()->input('page', 1);

        if(Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        } else {
            return Cache::rememberForever($cacheKey, function () {
                $categories = Category::simplePaginate(config('app.paginate'));

                return response()->json($categories);
            });
        }
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *     path="/api/categories/",
     *     operationId="category.create",
     *     tags={"Categories"},
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
     *                 required={"name"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="The product name",
     *                     default=""
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
    public function store(CategoryStore $request)
    {
        try {
            $category = new Category($request->validated());
            $category->save();

            return response()->json($category);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/categories/{uuid}",
     *     operationId="category.show",
     *     tags={"Categories"},
     *     summary="Show product",
     *     description="Show product endpoint",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="Category uuid",
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
    public function show(string $id)
    {
        try {
            $category = Category::findOrFail($id);

            return response()->json($category);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Patch(
     *     path="/api/categories/{uuid}",
     *     operationId="category.update",
     *     tags={"Categories"},
     *     summary="Update product",
     *     description="Update product endpoint",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="Category uuid",
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
     *                 required={"name"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="The product name",
     *                     default=""
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
    public function update(CategoryUpdate $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->fill($request->validated());
            $category->save();

            return response()->json($category);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Delete(
     *     path="/api/categories/{uuid}",
     *     operationId="category.destroy",
     *     tags={"Categories"},
     *     summary="Update product",
     *     description="Create product endpoint",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="Category uuid",
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
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(['message' => 'Category deleted successfully!']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
