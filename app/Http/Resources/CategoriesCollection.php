<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class CategoriesCollection
 * @package App\Http\Resources
 */
class CategoriesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        $data = [];

        foreach ($this->collection as $key => $item) {

            foreach ($item->translations as $translation) {
                $item->translations[$translation->locale] = $translation;
            }
            $data[$key] = [
                'id' => $item->id,
                'type' => 'categories',
                'attributes' => [
                    'alias' => $item->alias,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'translations' => [
                        'en' => [
                            'id' => $item->translations['en']->id,
                            'category_id' => $item->translations['en']->category_id,
                            'locale' => $item->translations['en']->locale,
                            'name' => $item->translations['en']->name,
                        ] ,
                        'ru' => [
                            'id' => $item->translations['ru']->id,
                            'category_id' => $item->translations['ru']->category_id,
                            'locale' => $item->translations['ru']->locale,
                            'name' => $item->translations['ru']->name,
                        ] ,
                    ]
                ]
            ];
        }
//        dump($data);
        return [
            'data' => $data
        ];
    }
}
