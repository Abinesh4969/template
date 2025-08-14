<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

    Route::post('register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
        
    
    Route::post('/check-unique-code', [AuthController::class, 'checkUniqueCode']);


    Route::middleware(['auth:sanctum'])->group(function () {
 
    Route::post('/updateKyc', [AuthController::class, 'updateKyc']);
        
    });


    Route::post('login', [AuthController::class, 'login']);


    require __DIR__.'/user.php';

    