<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TokenController extends Controller
{
    public function generate (Request $request) 
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);
     
        $user = User::where('phone', $request->phone)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
     
        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'message' => 'Login successful'
        ]);
    }
}