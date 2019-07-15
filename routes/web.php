<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['as' => 'blog', 'uses' => 'BlogController@index']);

Route::get('lang/{language}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

Auth::routes();

Route::namespace('Admin')->middleware('auth')->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('posts', 'PostController');
    Route::resource('users', 'UserController');

//    Route::get('/home', ['as' => 'home', 'uses' => 'AdminController@index']);
//    Route::get('ajax-categories', ['as' => 'ajax-regions', 'uses' => 'AjaxCategoryController@regions']);
//    Route::get('ajax-tags', ['as' => 'ajax-tags', 'uses' => 'AjaxTagController@tags']);
//    Route::get('ajax-municipalities/{region?}', [
//        'as' => 'ajax-municipalities', 'uses' => 'AjaxCategoryController@municipalities'
//    ]);
//    Route::post('ajax-dropzone-store', ['as' => 'ajax-dropzone-store', 'uses' => 'AjaxDropzoneController@storeFile']);
//    Route::post('ajax-dropzone-delete', ['as' => 'ajax-dropzone-delete', 'uses' => 'AjaxDropzoneController@deleteFile']);
//
//    Route::resource('images', 'ImageController');
//    Route::resource('slides', 'SlideController');
//    Route::resource('categories', 'CategoryController');
//    Route::resource('tags', 'TagController');



});
