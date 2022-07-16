<?php

namespace App\Http\Requests;

use App\Http\Requests\Auth\AuthRequest;
use App\Models\House;
use App\Models\Tenancy;
use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTenancyRequest extends AuthRequest
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
            'tenant' => [
                'name' => $this->tenant['name'],
                'phone' => str_replace(' ', '', preg_replace('/[^A-Za-z0-9. -]/', '', $this->tenant['phone']))
            ]
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
            'house_id' => [
                'required',
                Rule::exists('houses', 'id')->where(function ($query) {
                    return $query->where('apartment_id', $this->apartment->id);
                }),
                function ($attribute, $value, $fail) {
                    $house = House::find($value);
                    if (optional($house)->tenant) {
                        $fail("House $value is currently occupied.");
                    }
                }
            ],
            'meter_reading' => [
                'required',
                'numeric',
            ],
            'tenant.name' => 'required',
            'tenant.phone' => parent::rules()['phone'],
        ];
    }
}
