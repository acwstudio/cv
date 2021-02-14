<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreTagRequest
 * @package App\Http\Requests\API
 */
class StoreTagRequest extends FormRequest
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
            'data.type' => 'required|in:tags',
            'data.attributes' => 'required|array',
            'data.attributes.alias' => 'required|string',
            'data.attributes.translation' => 'required|array',
            'data.attributes.translation.locale' => 'required|string',
            'data.attributes.translation.name' => 'required|string',
        ];
    }
}
