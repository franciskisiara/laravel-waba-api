<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class LoginController extends Controller
{
    public function login (LoginRequest $request) 
    {
        $user = User::where('phone', $request->phone)->first();

        return response()->json([
            'data' => [
                'user' => new UserResource($user),
                'apartment' => $user->apartments()->first(),
                'token' => $user->createToken('default')->plainTextToken,
            ],

            'message' => 'Login successful'
        ], 201);
    }
}