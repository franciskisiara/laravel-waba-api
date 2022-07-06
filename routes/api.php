<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\TenantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('token/generate', [TokenController::class, 'generate']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('apartments', ApartmentController::class)->only([
        'store',
    ]);

    Route::prefix('apartments/{apartment}')->group(function () {
        Route::resource('houses', HouseController::class)->only([
            'index', 'store',
        ]);

        Route::resource('tenants', TenantController::class)->only([
            'index', 'store', 'destroy'
        ]);

        Route::resource('meter-readings', MeterReadingController::class)->only([
            'store',
        ]);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
