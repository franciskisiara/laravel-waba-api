<?php

namespace App\Http\Requests;

use App\Actions\VerificationCode;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
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
                Rule::exists(User::class, 'phone'),
                function ($attribute, $value, $fail) {
                    if (!Str::startsWith($value, '254')) {
                        $fail("Unsupported country's phone number.");
                    }
                }
            ],
            'code' => [
                'required',
                function ($attribute, $value, $fail) {
                    $user = User::where('phone', $this->phone)->firstOrFail();
                    $verified = (new VerificationCode)->verify($user, $value);
                    if (!$verified) {
                        $fail("Invalid verification code provided.");
                    }
                }
            ]
        ];
    }
}
