<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProperty extends FormRequest
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
            'country' => 'required|string|max:100',
            'suburb'  => 'string|max:255|nullable', // not-required, not all countries have suburb
            'state'   => 'string|max:255|nullable', // not-required, not all countries have state
        ];
    }
}
