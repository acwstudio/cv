<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CategoriesResource
 * @package App\Http\Resources
 */
class CategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'type' => 'categories',
            'attributes' => [
                'alias' => $this->alias,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'translation' => [
                    'locale' => app()->getLocale(),
                    'name' => $this->name,
                    'created_at' => $this->translate(app()->getLocale())->created_at,
                    'updated_at' => $this->translate(app()->getLocale())->updated_at,
                ]
            ],
            'relationships' => [
                'translations' => [
                    'links' => [
                        'self' => route('categories.relationships.translations',
                            ['id' => $this->id]),
                        'related' => route('categories.translations',
                            ['id' => $this->id])
                    ],

                    'data' => CategoriesIdentifierResource::collection($this->whenLoaded('translations')),
                ],
            ]
        ];
    }

    /**
     * @return array
     */
    private function relations()
    {
        return [
            CategoryTranslationsResource::collection($this->whenLoaded('translations'))
        ];
    }

    /**
     * @param $request
     * @return \Illuminate\Support\Collection
     */
    public function included($request)
    {
        return collect($this->relations())
            ->filter(function ($resource) {
                return $resource->collection !== null;
            })
            ->flatMap(function ($resource) use($request) {
                /** @var CategoriesResource $resource */
                return $resource->toArray($request);
            });
    }

    /**
     * @param Request $request
     * @return array
     */
    public function with($request)
    {
        $with = [];

        if ($this->included($request)->isNotEmpty()) {
            $with['included'] = $this->included($request);
        }

        return $with;
    }
}
