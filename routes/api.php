<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConstructionController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckManagerRole;
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

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::get('facilities/{id}', [FacilityController::class, 'show']);
    Route::resource('positions', PositionController::class);

    Route::middleware(CheckManagerRole::class)->group(function () {
        Route::put('facilities/{id}', [FacilityController::class, 'update']);
        Route::post('constructions', [ConstructionController::class, 'store']);
        Route::put('constructions/{id}', [ConstructionController::class, 'update']);
        Route::delete('constructions/{id}', [ConstructionController::class, 'delete']);
        Route::post('facilities', [FacilityController::class, 'store']);
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::get('roles', [UserController::class, 'getRoles']);
        Route::delete('users/{id}', [UserController::class, 'destroy']);
    });
});
