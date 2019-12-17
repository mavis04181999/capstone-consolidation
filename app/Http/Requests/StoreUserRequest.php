<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users,email'],
            'title' => ['sometimes', 'nullable'],
            'firstname' => ['required', 'min: 3'],

            'middlename' => ['sometimes', 'nullable', 'min: 3'],
            'lastname' => ['required', 'min: 3'],
            'nickname' => ['sometimes', 'nullable'],

            'certificate_name' => ['sometimes', 'nullable', 'min:3'],
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
            'username' => ['required', 'alpha_dash', 'min: 3', 'unique:users,username'],
            'role' => ['required'],
        ];
    }
}
