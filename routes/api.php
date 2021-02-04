<?php

use App\Http\Controllers\API\ApiCategoriesPostsRelatedController;
use App\Http\Controllers\API\ApiCategoriesPostsRelationshipsController;
use App\Http\Controllers\API\ApiCategoriesTranslationsRelatedController;
use App\Http\Controllers\API\ApiCategoriesTranslationsRelationshipsController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->prefix('v1')->group(function () {

    /********************  USERS ROUTES ****************/

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    /*****************  CATEGORIES ROUTES **************/

    Route::apiResource('categories', 'API\ApiCategoryController', ['as' => 'api']);

    /* relationships to posts */
    Route::get('categories/{category}/relationships/posts',
        [ApiCategoriesPostsRelationshipsController::class, 'index'])
        ->name('categories.relationships.posts');
    Route::patch('categories/{category}/relationships/posts',
        [ApiCategoriesPostsRelationshipsController::class, 'update'])
        ->name('categories.relationships.posts');
    Route::get('categories/{category}/posts',
        [ApiCategoriesPostsRelatedController::class, 'index'])
        ->name('categories.posts');

    /* relationships to translations */
    Route::get('categories/{category}/relationships/translations',
        [ApiCategoriesTranslationsRelationshipsController::class, 'index'])
        ->name('categories.relationships.translations');
    Route::patch('categories/{category}/relationships/translations',
        [ApiCategoriesTranslationsRelationshipsController::class, 'update'])
        ->name('categories.relationships.translations');
    Route::get('categories/{category}/translations',
        [ApiCategoriesTranslationsRelatedController::class, 'index'])
        ->name('categories.translations');
});
