<?php
namespace App\Http\Controllers\Auth;

use App\Actions\VerificationCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateCodeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CodeController extends Controller
{
    /**
     * Generate a verification code
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     */
    public function generate (GenerateCodeRequest $request) 
    {
        DB::transaction(function () use($request) {
            $user = User::where('phone', $request->phone)->first();
            (new VerificationCode)->generate($user);
        });

        return response()->json([
            'message' => 'Verification code generated successfully'
        ]);
    }
}