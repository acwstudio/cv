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
Route::get('post/{id}', ['as' => 'post', 'uses' => 'BlogController@show']);

Route::get('lang/{language}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

Auth::routes();

/* Admin panel */
Route::namespace('Admin')->middleware('auth')->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('posts', 'PostController');
    Route::resource('users', 'UserController');
    Route::resource('tags', 'TagController');
    Route::resource('categories', 'CategoryController');

    Route::post('activator',  ['as' => 'activator', 'uses' => 'AjaxController@activator']);
    Route::post('dropzone-store', ['as' => 'dropzone-store', 'uses' => 'DropzoneController@store']);
    Route::post('dropzone-delete', ['as' => 'dropzone-delete', 'uses' => 'DropzoneController@delete']);

});
