<?php

use App\Http\Controllers\{
    CommentsController,
    PostsController,
    UsersController
};
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

include base_path('routes/auth.php');

Route::middleware('auth:sanctum')->group(function() {
    // Posts routes.
    Route::apiResource('posts', PostsController::class);
    // Users route
    Route::apiResource('users', UsersController::class);
    // Route for adding comment
    Route::post('comments', [CommentsController::class, 'store']);
});
