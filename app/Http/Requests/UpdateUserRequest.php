<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'firstname' => ['required', 'min:3'],
            'middlename' => ['sometimes', 'nullable', 'min: 3'],
            'lastname' => ['required', 'min:3'],
            'email' => ['required', 'email', 'min:3'],
            'contactno' => ['sometimes', 'nullable', 'alpha_dash', 'min:3'],
            'address' => ['sometimes', 'min:3'],
            'department' => ['sometimes', 'nullable'],
            'course' => ['sometimes', 'nullable', 'min:3', 'exists:courses,abbr'],
            'section' => ['sometimes', 'nullable', 'min:3', 'alpha_dash', 'exists:sections,section'],
            'year' => ['sometimes', 'nullable', 'numeric'],
            'password' => ['sometimes', 'nullable', 'min:3']
        ];
    }
}
