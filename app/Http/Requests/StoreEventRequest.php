<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'event_name' => ['required', 'min: 3', 'unique:events,event_name'],
            'organizer_id' => ['required', 'numeric', 'exists:users,id'],
            'location' => ['sometimes', 'nullable', 'min:3'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'department_id' => ['sometimes', 'nullable', 'numeric', 'exists:departments,id'],
            'max_participants' => ['sometimes', 'nullable'],
            'allow_prereg' => ['required', 'numeric'],
            'prereg_slot' => ['sometimes', 'nullable'],
            'fee' => ['sometimes', 'nullable'],
            'event_overview' => ['sometimes', 'nullable']
        ];
    }
}
