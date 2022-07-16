<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'sometimes',
                'string',
            ], 
            'unit_rate' => [
                'sometimes',
                'numeric'
            ],
            'flat_rate' => [
                'numeric',
                'nullable',
                'required_with:flat_rate_limit'
            ],
            'flat_rate_limit' => [
                'numeric',
                'nullable',
                'required_with:flat_rate',
            ],
        ];
    }
}
