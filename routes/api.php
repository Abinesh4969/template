<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DropdownController;

    Route::post('register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
        
    Route::get('/states', [DropdownController::class, 'getStates']);
    Route::post('/get-districts', [DropdownController::class, 'getDistricts']);
    Route::post('/get-cities', [DropdownController::class, 'getCitiesByDistrict']);

    Route::post('/check-unique-code', [AuthController::class, 'checkUniqueCode']);


    Route::middleware(['auth:sanctum'])->group(function () {
 
    Route::post('/updatekyc', [AuthController::class, 'updateKyc']);
        
    });


    Route::post('login', [AuthController::class, 'login']);


    require __DIR__.'/user.php';

    