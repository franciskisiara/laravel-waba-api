<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class RegisterRequest extends AuthRequest
{
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
            'phone' => array_merge([
                Rule::unique(User::class),
            ], parent::rules()['phone']),
        ];
    }
}
