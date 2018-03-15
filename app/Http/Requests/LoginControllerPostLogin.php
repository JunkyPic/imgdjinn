<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginControllerPostLogin extends FormRequest
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
            'username' => 'required|string|max:50',
            'password' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function messages() {
        return [
            'username.required' => 'The username is required.',
            'username.max' => 'The username must be at most 50 characters long.',
            'password.required' => 'The password field is required.',
        ];
    }
}
