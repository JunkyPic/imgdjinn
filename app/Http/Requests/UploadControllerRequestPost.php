<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadControllerRequestPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // user is always atuhorized to make this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['img.*'] = 'image|mimes:jpeg,jpg,png,gif,webp|max:2048';
        $rules['img'] = 'required';

        if($this->request->has('create_password')) {
            $rules['password'] = 'required|max:255';
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function messages() {
        return [
            'img.required' => 'At least one image must be uploaded',
            'img.mimes' => 'The image must be of type jpeg,jpg,png(for now)',
            'img.max' => 'The image(s) must not be larger than 2MB',
        ];
    }
}
