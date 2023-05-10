<?php

use App\Http\Controllers\Auth\{
    AuthController,
    ResetPasswordController,
};

use App\Http\Controllers\Admin\{
    UserController,
};

use Illuminate\Support\Facades\Route;

/* Auth Routes */
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware(['guest'])->group(function () {
        Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink']);
        Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
    });
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

/* Routes Admin Dashboard */
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/admin/users', UserController::class);
});

Route::get('/', function () {
    return response()->json(['status' => true]);
});