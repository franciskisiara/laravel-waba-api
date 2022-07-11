<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\Auth\CodeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\TenancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('code/generate', [CodeController::class, 'generate']);
Route::post('register', [RegisterController::class, 'store']);
Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('apartments', ApartmentController::class)->only([
        'store',
    ]);

    Route::prefix('apartments/{apartment}')->group(function () {
        Route::resource('houses', HouseController::class)->only([
            'index', 'store',
        ]);

        Route::resource('tenancies', TenancyController::class)->only([
            'store', 'destroy'
        ]);

        Route::resource('meter-readings', MeterReadingController::class)->only([
            'store',
        ]);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
