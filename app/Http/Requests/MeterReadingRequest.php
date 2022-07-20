<?php

namespace App\Http\Requests;

use App\Models\Tenancy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MeterReadingRequest extends FormRequest
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
        $tenancy = Tenancy::where('id', $this->tenancy_id)
            ->whereHas('house.apartment', function ($builder) {
                $builder->where('apartment_id', $this->apartment->id);
            })
            ->first();

        return [
            'tenancy_id' => [
                'required',
                function ($attribute, $value, $fail) use($tenancy) {
                    if (!$tenancy) {
                        $fail("The selected tenancy does not exist.");
                    }

                    if ($tenancy && $tenancy->deleted_at != null) {
                        $fail("You cannot record meter readings for an ended tenancy.");
                    }
                }
            ],

            'meter_reading' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use($tenancy) {
                    if ($tenancy != null) {     
                        $readings = $tenancy->readings()->orderBy('id', 'desc');

                        $monthReading = $readings->get()->first(function ($reading, $key) {
                            return $reading->created_at->month == now()->month;
                        });

                        if (!is_null($monthReading)) {
                            $fail("You have already recorded this month's reading.");
                        }

                        if ($value < $readings->first()->current_units) {
                            $fail("The current reading cannot be less that the previous reading.");
                        }
                    } 
                }
            ],
        ];
    }
}
