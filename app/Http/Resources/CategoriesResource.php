<?php

namespace App\Http\Resources;

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
//        return parent::toArray($request);

        foreach ($this->translations as $key => $translation) {
            $translations[$translation->locale] = $translation;
        }


        return [
            'id' => $this->id,
            'type' => 'categories',
            'attributes' => [
                'alias' => $this->alias,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'translations' => $translations
            ]
        ];
    }
}
