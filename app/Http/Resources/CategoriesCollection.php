<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\MissingValue;

/**
 * Class CategoriesCollection
 * @package App\Http\Resources
 */
class CategoriesCollection extends ResourceCollection
{
    public $collects = CategoriesResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'included' => $this->mergeIncludedRelations($request),
        ];
    }

    /**
     * @param $request
     * @return MissingValue|\Illuminate\Support\Collection
     */
    private function mergeIncludedRelations($request)
    {
        $includes = $this->collection->flatMap(function ($resource) use($request){
            /** @var CategoriesResource $resource */
            return $resource->included($request);
        });

        return $includes->isNotEmpty() ? $includes : new MissingValue();
    }
}
