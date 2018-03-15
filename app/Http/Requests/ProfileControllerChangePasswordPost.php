<?php

namespace App\Http\Requests;

use App\Rules\SamePassword;
use Illuminate\Foundation\Http\FormRequest;

class ProfileControllerChangePasswordPost extends FormRequest
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
            'cpassword' => 'required|string|db_pwd_same',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * @return array
     */
    public function messages() {
        return [
            'cpassword.required' => 'The current password is required',
            'cpassword.db_pwd_same' => 'The current password is incorrect',
            'password.min' => 'The password must be at least 6 characters long.',
            'password.confirmed' => 'The passwords do not match.',
        ];
    }
}
