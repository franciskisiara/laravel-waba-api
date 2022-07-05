<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\TenantController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::post('token/generate', function (Request $request) {
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
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('apartments', ApartmentController::class)->only([
        'store',
    ]);

    Route::prefix('apartments/{apartment}')->group(function () {
        Route::resource('houses', HouseController::class)->only([
            'store',
        ]);

        Route::resource('tenants', TenantController::class)->only([
            'store',
        ]);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
