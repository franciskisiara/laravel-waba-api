<?php
namespace App\Http\Controllers\Auth;

use App\Actions\VerificationCode;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class RegisterController extends Controller
{
    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(RegisterRequest $request)
    {
        DB::transaction(function () use($request) {
            $user = User::create($request->only([
                'name', 'phone'
            ]));

            (new VerificationCode)->generate($user);
        });

        return response()->json([
            'message' => 'Waba account created successfully'
        ]);
    }
}