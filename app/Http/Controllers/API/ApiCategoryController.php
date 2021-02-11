<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Requests\API\StoreCategoryRequest;
use App\Http\Requests\API\UpdateCategoryRequest;
use App\Http\Resources\CategoriesCollection;
use App\Http\Resources\CategoriesResource;
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
        $categories = QueryBuilder::for(Category::class)
            ->select('categories.*', 'category_translations.name')
            ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.locale', '=', 'en')
            ->allowedSorts(['id', 'name'])
            ->allowedIncludes('translations')
            ->jsonPaginate();

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
        $locale = $request->input('data.attributes.translation.locale');
        $name = $request->input('data.attributes.translation.name');

        $category = Category::create([
            'alias' => $request->input('data.attributes.alias'),
            $locale => ['name' => $name]
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
     * @param Category $category
     * @return CategoriesResource
     */
    public function show($category)
    {
        $query = QueryBuilder::for(Category::where('id', $category))
            ->allowedIncludes('translations')
            ->firstOrFail();

        return new CategoriesResource($query);
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
        $locale = $request->input('data.attributes.translation.locale');
        $name = $request->input('data.attributes.translation.name');

        $category->update($request->input('data.attributes'));
        $category->translate($locale)->name = $name;
        $category->save();

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
