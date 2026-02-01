<?php

namespace App\Http\Controllers\Inventory\Category;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Category;
use App\Http\Requests\Inventory\Category\StoreCategoryRequest;
use App\Http\Requests\Inventory\Category\UpdateCategoryRequest;
use App\Http\Resources\Inventory\Category\CategoryResource;
use App\Http\Resources\Inventory\BarangResource;
use App\Http\Resources\Inventory\Category\CategoryCollection;
use App\Support\ApiMeta;
use App\Support\HttpMessage;
use App\Support\HttpStatus;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Category::class);

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new CategoryCollection(
                Category::orderBy('nama')->get()
            ),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::CREATED),
            'data'    => new CategoryResource($category),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::CREATED);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data'    => new CategoryResource($category),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => HttpMessage::fromStatus(HttpStatus::OK),
            'data' => new BarangResource($barang),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }
}
