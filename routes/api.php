<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', '\App\Http\Controllers\AuthController@register')->name("user.register");
    Route::post('login', '\App\Http\Controllers\AuthController@login')->name("user.login");
});

Route::middleware('auth:api')->group(function() {
    Route::prefix('sms')->group(function() {
        Route::get('/{date?}', [\App\Http\Controllers\SMSController::class, 'index'])->name("sms.index");
        Route::get('show/{id}', [\App\Http\Controllers\SMSController::class, 'show'])->name("sms.show");
        Route::post('send', [\App\Http\Controllers\SMSController::class, 'sendSms'])->name("sms.store");
    });
});
