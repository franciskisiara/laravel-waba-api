<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthRequest extends FormRequest
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
            'phone' => str_replace(' ', '', preg_replace('/[^A-Za-z0-9. -]/', '', $this->phone)),
        ]);
    }

    // /**
    //  * Get custom attributes for validator errors.
    //  *
    //  * @return array
    //  */
    // public function attributes()
    // {
    //     return [
    //         'phone' => 'phone number',
    //     ];
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phone' => [
                'required',
                'between:12,15',
                function ($attribute, $value, $fail) {
                    if (!Str::startsWith($value, '254')) {
                        $fail("Unsupported country's phone number.");
                    }
                }
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.exists' => 'The provided phone number does not exist'
        ];
    }
}