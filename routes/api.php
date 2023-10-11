<?php

use App\Http\Controllers\AuthController;
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

    Route::middleware(CheckManagerRole::class)->group(function () {
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::get('roles', [UserController::class, 'getRoles']);
        Route::delete('users/{id}', [UserController::class, 'destroy']);
        Route::resource('positions', PositionController::class);
    });
});
