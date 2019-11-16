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
            'username' => ['required', 'alpha_dash', 'min:3', 'unique:users'],
            'role' => ['required'],
            'firstname' => ['required', 'min:3'],
            'middlename' => ['sometimes', 'nullable', 'min: 3'],
            'lastname' => ['required', 'min:3'],
            'email' => ['required', 'email', 'min:3', 'unique:users'],
            'contactno' => ['sometimes', 'alpha_dash', 'min:3'],
            'address' => ['sometimes', 'min:3'],
            'department' => ['sometimes', 'nullable'],
            'course' => ['sometimes', 'nullable', 'min:3'],
            'section' => ['sometimes', 'nullable', 'min:3', 'alpha_dash'],
            'year' => ['sometimes', 'nullable', 'numeric'],
        ];
    }
}
