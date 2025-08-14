<?php

use Illuminate\Support\Facades\Route;

    Route::middleware(['auth:sanctum', 'role:user'])->prefix('user')->group(function () {
    
        
        
    });