<?php

use App\Http\Controllers\API\ApiCategoryPostsRelatedController;
use App\Http\Controllers\API\ApiCategoryPostsRelationshipsController;
use App\Http\Controllers\API\ApiCategoryTranslationsRelatedController;
use App\Http\Controllers\API\ApiCategoryTranslationsRelationshipsController;
use App\Http\Controllers\API\ApiTagsPostsRelatedController;
use App\Http\Controllers\API\ApiTagsPostsRelationshipsController;
use App\Http\Controllers\API\ApiTagTranslationsRelatedController;
use App\Http\Controllers\API\ApiTagTranslationsRelationshipsController;
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

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    /*****************  CATEGORIES ROUTES **************/

    Route::apiResource('categories', 'API\ApiCategoryController', ['as' => 'api']);

    /* relationships to posts */
    Route::get('categories/{category}/relationships/posts',
        [ApiCategoryPostsRelationshipsController::class, 'index'])
        ->name('categories.relationships.posts');
    Route::patch('categories/{category}/relationships/posts',
        [ApiCategoryPostsRelationshipsController::class, 'update'])
        ->name('categories.relationships.posts');
    Route::get('categories/{category}/posts',
        [ApiCategoryPostsRelatedController::class, 'index'])
        ->name('categories.posts');

    /* relationships to translations */
    Route::get('categories/{category}/relationships/translations',
        [ApiCategoryTranslationsRelationshipsController::class, 'index'])
        ->name('categories.relationships.translations');
    Route::patch('categories/{category}/relationships/translations',
        [ApiCategoryTranslationsRelationshipsController::class, 'update'])
        ->name('categories.relationships.translations');
    Route::get('categories/{category}/translations',
        [ApiCategoryTranslationsRelatedController::class, 'index'])
        ->name('categories.translations');

    /********************  TAGS ROUTES *****************/

    Route::apiResource('tags', 'API\ApiTagController', ['as' => 'api']);

    /* relationships to posts */
    Route::get('tags/{tag}/relationships/posts',
        [ApiTagsPostsRelationshipsController::class, 'index'])
        ->name('categories.relationships.posts');
    Route::patch('tags/{tag}/relationships/posts',
        [ApiTagsPostsRelationshipsController::class, 'update'])
        ->name('tags.relationships.posts');
    Route::get('tags/{tag}/posts',
        [ApiTagsPostsRelatedController::class, 'index'])
        ->name('tags.posts');

    /* relationships to translations */
    Route::get('tags/{tag}/relationships/translations',
        [ApiTagTranslationsRelationshipsController::class, 'index'])
        ->name('tags.relationships.translations');
    Route::patch('tags/{tag}/relationships/translations',
        [ApiTagTranslationsRelationshipsController::class, 'update'])
        ->name('tags.relationships.translations');
    Route::get('tags/{tag}/translations',
        [ApiTagTranslationsRelatedController::class, 'index'])
        ->name('tags.translations');

    /********************  POSTS ROUTES *****************/

    Route::apiResource('posts', 'API\ApiPostController', ['as' => 'api']);
});
