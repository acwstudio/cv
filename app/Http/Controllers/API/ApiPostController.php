<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\StorePostRequest;
use App\Http\Requests\API\UpdatePostRequest;
use App\Http\Resources\PostsCollection;
use App\Http\Resources\PostsResource;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class ApiPostController
 * @package App\Http\Controllers\API
 */
class ApiPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PostsCollection
     */
    public function index()
    {
        $posts = QueryBuilder::for(Post::class)
            ->select('posts.*', 'post_translations.title')
            ->join('post_translations', 'posts.id', '=', 'post_translations.post_id')
            ->where('post_translations.locale', '=', 'en')
            ->allowedSorts(['title', 'created_at'])
            ->allowedIncludes('translations')
            ->jsonPaginate();

        return new PostsCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return PostsResource
     */
    public function show(Post $post)
    {
        return new PostsResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
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
