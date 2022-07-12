<?php

namespace App\Http\Requests\Auth;

use App\Actions\VerificationCode;
use App\Models\User;
use Illuminate\Validation\Rule;

class LoginRequest extends AuthRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' => [
                'required',
                function ($attribute, $value, $fail) {
                    $user = User::where('phone', $this->phone)->firstOrFail();
                    $verified = (new VerificationCode)->verify($user, $value);
                    if (!$verified) {
                        $fail("Invalid verification code provided.");
                    }
                }
            ],
            'phone' => array_merge([
                Rule::exists(User::class, 'phone'),
            ], parent::rules()['phone']),
        ];
    }
}
