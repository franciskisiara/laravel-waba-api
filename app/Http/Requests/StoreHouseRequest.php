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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'house_number' => str_replace(' ', '', strtoupper($this->house_number)),
        ]);
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
                Rule::unique('houses', 'house_number')
                    ->where(function ($query) {
                        return $query->where('apartment_id', $this->apartment->id);
                    }),
            ],
        ];
    }
}
