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
     */
    public function index()
    {
        $cacheKey = 'categories_' . request()->input('page', 1);

        if( Cache::has($cacheKey) ) {
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
