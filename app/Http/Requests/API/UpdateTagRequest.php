<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateTagRequest
 * @package App\Http\Requests\API
 */
class UpdateTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data' => 'required|array',
            'data.id' => 'required|string',
            'data.type' => 'required|in:tags',
            'data.attributes' => 'array',
            'data.attributes.alias' => 'string',
            'data.attributes.translation' => 'array',
            'data.attributes.translation.locale' => [
                Rule::in([app()->getLocale()])
            ],
            'data.attributes.translation.name' => 'string',
        ];
    }
}
