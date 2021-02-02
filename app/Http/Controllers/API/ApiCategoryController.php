<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Requests\API\StoreCategoryRequest;
use App\Http\Resources\CategoriesCollection;
use App\Http\Resources\CategoriesResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $categories = Category::all();

        return new CategoriesCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        return $request;
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
