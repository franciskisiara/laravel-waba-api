<?php
namespace App\Http\Controllers\Auth;

use App\Actions\VerificationCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GenerateCodeRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        $user = DB::transaction(function () use($request) {
            $user = User::where('phone', $request->phone)->first();
            (new VerificationCode)->generate($user);
            return $user;
        });

        return response()->json([
            'data' => [
                'user' => new UserResource($user),
            ],
            'message' => 'Verification code generated successfully'
        ]);
    }
}