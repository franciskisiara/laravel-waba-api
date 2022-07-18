<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\Auth\CodeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\TenancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [RegisterController::class, 'register']);
Route::post('code/generate', [CodeController::class, 'generate']);
Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('apartments', ApartmentController::class)->only([
        'store',
    ]);

    Route::middleware('caretaker')->prefix('apartments/{apartment}')->group(function () {
        Route::patch('/', [ApartmentController::class, 'update']);

        Route::resource('houses', HouseController::class)->only([
            'index', 'store',
        ]);

        Route::resource('tenancies', TenancyController::class)->only([
            'index', 'store', 'destroy'
        ]);

        Route::resource('meter-readings', MeterReadingController::class)->only([
            'index', 'store',
        ]);
    });
});