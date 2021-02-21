<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PostsResource
 * @package App\Http\Resources
 */
class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'type' => 'posts',
            'attributes' => [
                'user_id' => $this->user_id,
                'category_id' => $this->category_id,
                'active' => $this->active,
                'image_name' => $this->image_name,
                'image_extension' => $this->image_extension,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'translation' => [
                    'locale' => app()->getLocale(),
                    'title' => $this->title,
                    'body' => $this->body,
                    'created_at' => $this->translate(app()->getLocale())->created_at,
                    'updated_at' => $this->translate(app()->getLocale())->updated_at,
                ]
            ],
//            'relationships' => [
//                'translations' => [
//                    'links' => [
//                        'self' => route('categories.relationships.translations',
//                            ['id' => $this->id]),
//                        'related' => route('categories.translations',
//                            ['id' => $this->id])
//                    ],
//
//                    'data' => CategoryTranslationsIdentifierResource::collection($this->whenLoaded('translations')),
//                ],
//            ]
        ];
    }
}
