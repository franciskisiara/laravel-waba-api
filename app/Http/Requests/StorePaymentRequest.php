<?php

namespace App\Http\Requests;

use App\Models\Tenancy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
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
            'tenancy_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $tenancy = Tenancy::where('id', $value)
                        ->whereHas('house.apartment', function ($builder) {
                            $builder->where('apartments.id', $this->apartment->id);
                        })->first();

                    if (is_null($tenancy)) {
                        $fail("Tenancy does not exist.");
                    }
                }
            ],

            'amount' => [
                'required',
                'numeric',
                'min:1'
            ]
        ];
    }
}
