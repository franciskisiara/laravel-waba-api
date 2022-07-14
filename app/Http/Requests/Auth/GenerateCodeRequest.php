<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Validation\Rule;

class GenerateCodeRequest extends AuthRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $parentRules = parent::rules()['phone'];

        return [
            'phone' => array_merge($parentRules, [
                Rule::exists(User::class),
            ]),
        ];
    }
}
