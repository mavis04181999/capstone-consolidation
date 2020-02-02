<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'user_id' => ['required', 'numeric'],

            'email' => ['required', 'email'],
            'title' => ['sometimes', 'nullable'],
            'firstname' => ['required', 'min: 3'],

            'middlename' => ['sometimes', 'nullable', 'min: 3'],
            'lastname' => ['required', 'min: 3'],
            'nickname' => ['required', 'min: 3'],
            'certificate_name' => ['required', 'min: 3'],

            'contactno' => ['sometimes', 'nullable'],
            'address' => ['sometimes', 'nullable'],
            'occupation' => ['sometimes', 'nullable'],

            'sex' => ['sometimes', 'nullable'],
            'birthday' => ['sometimes', 'nullable'],
            'department' => ['sometimes', 'nullable', 'numeric'],
            
            'course' => ['sometimes', 'nullable', 'numeric'],
            'section' => ['sometimes', 'nullable', 'numeric'],
            'year' => ['sometimes', 'nullable', 'numeric'],
            'institution' => ['sometimes', 'nullable', 'min: 3'],
            
            'password' => ['sometimes', 'nullable', 'min: 3']
        ];
    }
}
