<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class RegisterController extends Controller
{
    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\CreatesNewUsers  $creator
     * @return \Laravel\Fortify\Contracts\RegisterResponse
     */
    public function store(Request $request, CreatesNewUsers $creator)
    {
        $user = $creator->create($request->all());

        // event(new Registered($user));

        // $token = $user->createToken('default')->plainTextToken;

        // return response()->json([
        //     'data' => [
        //         'user' => $user,
        //         'token' => $token,
        //         'apartment' => $user->apartments()->first(),
        //     ],

        //     'message' => 'Account created successfully'
        // ]);
    }
}