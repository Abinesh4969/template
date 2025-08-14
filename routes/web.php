<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;
    
Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
        
Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/userdata', [UserController::class, 'userdata'])->name('users.data');
    Route::get('/user/show/{id}', [UserController::class, 'usershow'])->name('usershow');
    Route::get('/deleteaccount', [UserController::class, 'deleteaccount'])->name('users.deleteaccount');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::post('/user/register', [UserController::class, 'register'])->name('users.register');
    Route::get('/users/{id}/show', [UserController::class, 'show'])->name('admin.users.show');


    // Route::get('login', [AuthenticatedSessionController::class, 'create'])
    //     ->name('login');
    // states
    Route::resource('states', StateController::class);
    Route::get('states-data', [StateController::class, 'data'])->name('states_data');
    Route::post('states/{id}/restore', [StateController::class, 'restore'])->name('states.restore');
    // districts
    Route::resource('districts', DistrictController::class);
    Route::get('districts-data', [DistrictController::class, 'data'])->name('districts_data');
    Route::post('districts/{id}/restore', [DistrictController::class, 'restore'])->name('districts.restore');
    // cities
    Route::resource('cities', CityController::class);
    Route::get('cities-data', [CityController::class, 'data'])->name('cities_data');
    Route::post('cities/{id}/restore', [CityController::class, 'restore'])->name('cities.restore');

    // subscriptions
      Route::resource('plans', PlanController::class)->except(['show']);
      Route::get('/plans_data', [PlanController::class, 'getData'])->name('plans.data');

});

require __DIR__.'/auth.php';
