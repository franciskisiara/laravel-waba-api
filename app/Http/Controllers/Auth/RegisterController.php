<?php
namespace App\Http\Controllers\Auth;

use App\Actions\VerificationCode;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function register (RegisterRequest $request)
    {
        $user = DB::transaction(function () use($request) {
            $user = User::create($request->only([
                'name', 'phone'
            ]));

            (new VerificationCode)->generate($user);

            return $user;
        });

        return response()->json([
            'data' => [
                'user' => new UserResource($user),
            ],
            'message' => 'Waba account created successfully'
        ], 201);
    }
}