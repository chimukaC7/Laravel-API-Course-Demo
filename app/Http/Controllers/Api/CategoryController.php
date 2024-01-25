<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Categories
 *
 * Managing Categories
 */
class CategoryController extends Controller
{
    /**
     * Get Categories
     *
     * List all the categories
     *
     * @queryParam page which page to show. Example: 2
     */
    public function index()
    {
        if (!auth()->user()->tokenCan('categories-list')) {
            abort(403, 'Unauthorized');
        }
        $categories = Category::with('products')->get();
        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        if (!auth()->user()->tokenCan('categories-show')) {
            abort(403, 'Unauthorized');
        }
        return new CategoryResource($category);
    }

    /**
     * Post Categories
     *
     * Create new category
     *
     * @bodyParam name string required Name of the category. Example: "Clothing"
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = 'categories/' . uniqid() . '.' . $file->extension();
            $file->storePubliclyAs('public', $name);
            $data['photo'] = $name;
        }
        $category = Category::create($data);

        return new CategoryResource($category);
    }

    public function update(Category $category, StoreCategoryRequest $request)
    {
        $category->update($request->all());

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
