<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserCreateRequest
 *
 * @package App\Http\Requests
 */
class UserCreateRequest extends FormRequest
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
        if ($this->attributes->has('role')) {

            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->request->has('password_confirmation') ?
                    ['required', 'string', 'min:8', 'confirmed'] :
                    ['required', 'string', 'min:8'],
                'role' => ['required', 'string'],
            ];

        } else {

            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->request->has('password_confirmation') ?
                    ['required', 'string', 'min:8', 'confirmed'] :
                    ['required', 'string', 'min:8'],
            ];

        }
    }
}
