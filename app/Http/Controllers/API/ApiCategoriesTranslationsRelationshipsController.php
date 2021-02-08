<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Resources\CategoriesIdentifierResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ApiCategoriesTranslationsRelationshipsController
 * @package App\Http\Controllers\API
 */
class ApiCategoriesTranslationsRelationshipsController extends Controller
{
    /**
     * @param Category $category
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Category $category)
    {
        return CategoriesIdentifierResource::collection($category->translations);
    }

    public function update()
    {

    }
}
