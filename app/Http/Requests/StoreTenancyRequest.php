<?php

namespace App\Http\Requests;

use App\Models\House;
use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTenancyRequest extends FormRequest
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
            'house_id' => [
                'required',
                Rule::exists(House::class, 'id'),
                function ($attribute, $value, $fail) {
                    $house = House::find($value);
                    if ($house->tenant) {
                        $fail("House $house->house_number is currently occupied.");
                    }
                }
            ],

            'meter_reading' => [
                'required',
                'numeric',
            ],

            'tenant.name' => [
                'required',
            ],

            'tenant.phone' => [
                'required',
            ],
        ];
    }
}
