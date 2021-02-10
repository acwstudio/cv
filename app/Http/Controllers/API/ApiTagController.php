<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\TagsCollection;
use App\Http\Resources\TagsResource;
use App\Tag;
use App\TagTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ApiTagController
 * @package App\Http\Controllers\API
 */
class ApiTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TagsCollection
     */
    public function index()
    {
        $tags = Tag::all();

        return new TagsCollection($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $locale = $request->input('data.attributes.translation.locale');
        $name = $request->input('data.attributes.translation.name');

        $tag = Tag::create([
           'alias' => $request->input('data.attributes.alias'),
            $locale => ['name' => $name]
        ]);

        return (new TagsResource($tag))
            ->response()
            ->header('Location', route('api.tags.show', [
                'tag' => $tag
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return TagsResource
     */
    public function show(Tag $tag)
    {
        return new TagsResource($tag);
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
