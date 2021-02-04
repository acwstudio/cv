<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CategoryTranslationsResource
 * @package App\Http\Resources
 */
class CategoryTranslationsResource extends JsonResource
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
            'type' => 'categories',
            'attributes' => [
                'alias' => $this->alias,
                'name' => $this->name,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'translations' => [
                    'links' => [
                        'self' => route('categories.relationships.translations',
                            ['id' => $this->id]),
                        'related' => route('categories.translations',
                            ['id' => $this->id])
                    ],
                    'data' => $this->translations->map(function ($translation) {
                        return [
                            'id' => (string)$translation->id,
                            'type' => 'category_translations'
                        ];
                    })
                ],
            ]
        ];
    }
}
