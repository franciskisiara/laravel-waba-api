<?php
namespace App\Actions;

use App\Library\SMS\AT;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class VerificationCode
{
    private const KEY = 'user_';
    private const EXPIRY = 60 * 60 * 24;
    private const PREFIX = 'verification_codes:';

    private function redisKey ($user) 
    {
        return VerificationCode::PREFIX . VerificationCode::KEY  . $user->id;
    }

    public function generate (User $user) 
    {
        $code = rand(1000, 9999);

        Redis::set($this->redisKey($user), Hash::make($code), 'EX', VerificationCode::EXPIRY);

        (new AT)->send([
            'to' => $user->phone,
            'message' => "$code is your Waba verification code"
        ]);
    }

    public function verify (User $user, $code) 
    {
        $key = $this->redisKey($user);
        $hashedCode = Redis::get($key);
        Redis::del($key);

        if (is_null($user->phone_verified_at)) {
            $user->update([
                'phone_verified_at' => now(),
            ]);
        }
        return Hash::check($code, $hashedCode);
    }
}