<?php
namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create($request->only([
            'name', 'phone'
        ]));

        $code = rand(1000, 9999);

        dd($code);

        dd($request->all());

        // $user = $creator->create($request->all());

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