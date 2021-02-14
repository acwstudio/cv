<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\StoreTagRequest;
use App\Http\Requests\API\UpdateTagRequest;
use App\Http\Resources\TagsCollection;
use App\Http\Resources\TagsResource;
use App\Tag;
use App\TagTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

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
        $tags = QueryBuilder::for(Tag::class)
            ->select('tags.*', 'tag_translations.name')
            ->join('tag_translations', 'tags.id', '=', 'tag_translations.tag_id')
            ->where('tag_translations.locale', '=', 'en')
            ->allowedSorts(['name', 'created_at'])
            ->allowedIncludes('translations')
//            ->get();
            ->jsonPaginate();

        return new TagsCollection($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTagRequest $request)
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
     * @return TagsResource
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update($request->all());

        return new TagsResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response(null, 204);
    }
}
