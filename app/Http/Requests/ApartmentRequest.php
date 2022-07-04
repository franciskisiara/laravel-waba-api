<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApartmentRequest extends FormRequest
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
                'required',
                'string',
            ], 
            'flat_rate_limit' => [
                'numeric',
            ],
            'flat_rate' => [
                'numeric',
                Rule::requiredIf($this->flat_rate_limit > 0)
            ], 
            'unit_rate' => [
                'required',
                'numeric'
            ],
        ];
    }
}
