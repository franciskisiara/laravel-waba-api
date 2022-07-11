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

    }

    /**
     * Verify the codes generated and sent to phone numbers
     */
    public function verify () 
    {
        
    }
}