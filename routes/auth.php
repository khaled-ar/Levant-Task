<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes.
|
*/

Route::prefix('auth')
    ->controller(AuthController::class)
    ->group(function() {
        // Register Route.
        Route::post('register', 'register');
        // Login Route.
        Route::post('login', 'login');
    });

