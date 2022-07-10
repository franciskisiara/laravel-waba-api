<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TokenController extends Controller
{
    public function generate (Request $request) 
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);
     
        $user = User::where('username', $request->username)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'data' => [
                'user' => $user,
                'apartment' => $user->apartments()->first(),
                'token' => $user->createToken($request->device_name)->plainTextToken,
            ],

            'message' => 'Login successful'
        ]);
    }
}