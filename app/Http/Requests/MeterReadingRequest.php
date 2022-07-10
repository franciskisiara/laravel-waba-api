<?php

namespace App\Http\Requests;

use App\Models\Tenancy;
use Illuminate\Foundation\Http\FormRequest;

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
        $tenancy = Tenancy::withTrashed()
            ->where('id', $this->tenancy_id)
            ->firstOrFail();

        return [
            'tenancy_id' => [
                'required',
                function ($attribute, $value, $fail) use($tenancy) {
                    if ($tenancy->deleted_at != null) {
                        $fail("You cannot record meter readings for an ended tenancy.");
                    }
                }
            ],

            'meter_reading' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use($tenancy) {
                    $lastReading = $tenancy->readings()->orderBy('id', 'desc')->first();
                    if ($value < $lastReading->current_units) {
                        $fail("The current reading cannot be less that the previous reading.");
                    }
                }
            ],
        ];
    }
}
