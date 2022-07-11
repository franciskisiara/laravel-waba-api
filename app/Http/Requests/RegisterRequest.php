<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class RegisterRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => str_replace(' ', '', preg_replace('/[^A-Za-z0-9. -]/', '', $this->phone)),
        ]);
    }

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
                'max:255'
            ],

            'phone' => [
                'min:12',
                'max:15',
                'required',
                Rule::unique(User::class),
                function ($attribute, $value, $fail) {
                    if (!Str::startsWith($value, '254')) {
                        $fail("Invalid country's phone number.");
                    }
                }
            ],
        ];
    }
}
