<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\Auth\CodeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TenancyController;
use App\Library\SMS\AT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/canvas', function () {
    $at = new AT();

    $frank = $at->send([
        'to' => '+254723258119',
        'message' => 'Franko ... umeget'
    ]);

    // $matis = $at->send([
    //     'to' => '+254723258119',
    //     'message' => 'Matis ... yumpy yump'
    // ]);

    return $frank;
});

Route::post('callback/at-delivery-reports', function () {
    Log::channel('slack')->info(json_encode(request()->all()));

    // {
    //     "phoneNumber": "+254711887341",
    //     "failureReason": "UserInBlackList",
    //     "retryCount": "0",
    //     "id": "ATXid_18b050cb7eaf75eb692f9830a6178910",
    //     "status": "Failed",
    //     "networkCode": "63902"
    //   }
});

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

        Route::resource('payments', PaymentController::class)->only([
            'store',
        ]);
    });
});