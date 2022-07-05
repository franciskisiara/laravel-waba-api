<?php

namespace App\Http\Requests;

use App\Models\House;
use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTenantRequest extends FormRequest
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
                    $tenant = Tenant::where([
                        'house_id' => $value,
                        'deleted_at' => null,
                    ])->first();

                    if ($tenant) {
                        $fail('The house has an active tenant');
                    }
                }
            ],

            'user' => [
                'name' => [
                    'required'
                ],

                'phone' => [
                    'required',
                    /** Starts with 254 for now */
                ]
            ],

            'current_reading' => [
                'required',
                'numeric',
            ]
        ];
    }
}
