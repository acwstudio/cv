<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Requests\API\StoreCategoryRequest;
use App\Http\Requests\API\UpdateCategoryRequest;
use App\Http\Resources\CategoriesCollection;
use App\Http\Resources\CategoriesResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;


/**
 * Class ApiCategoryController
 * @package App\Http\Controllers\API
 */
class ApiCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CategoriesCollection
     */
    public function index()
    {
        $categories = QueryBuilder::for(Category::class)->allowedSorts([
            'alias',
            'created_at',
            'updated_at',
        ])->jsonPaginate();
        return new CategoriesCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create([
            'alias' => $request->input('data.attributes.alias')
        ]);

        return (new CategoriesResource($category))
            ->response()
            ->header('Location', route('api.categories.show', [
                'category' => $category
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CategoriesResource
     */
    public function show(Category $category)
    {
        return new CategoriesResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return CategoriesResource
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->input('data.attributes'));

        return new CategoriesResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response(null, 204);
    }
}
