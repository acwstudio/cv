<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TagsResource
 * @package App\Http\Resources
 */
class TagsResource extends JsonResource
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
            'type' => 'tags',
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
            ]
        ];
    }
}
