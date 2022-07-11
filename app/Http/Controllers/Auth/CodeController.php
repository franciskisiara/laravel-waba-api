<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class CodeController extends Controller
{
    /**
     * Generate a verification code
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     */
    public function generate () 
    {
        // Validator::make($input, [
        //     'name' => [
        //         'required', 
        //         'string', 
        //         'max:255'
        //     ],
        //     'phone' => [
        //         'required',

                
        //         Rule::unique(User::class),
        //     ],
        // ])->validate();
    }
}