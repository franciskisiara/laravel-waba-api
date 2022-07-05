<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreHouseRequest extends FormRequest
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
            'house_number' => [
                'required',
                Rule::unique('houses')->where(function ($query) {
                    return $query->where('apartment_id', $this->apartment->id);
                }),
            ],

            'initial_reading' => [
                'required',
                'numeric',
            ],
        ];
    }
}
