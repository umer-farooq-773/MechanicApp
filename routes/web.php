<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/page', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/', [UserController::class, 'showLoginForm'])->name('login');
    Route::post('/', [UserController::class, 'login']);

    // Registration routes
    Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [UserController::class, 'register']);

    // Forgot password routes
    Route::get('/forgot-password', [UserController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [UserController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [UserController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Protected routes
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
// Route::resource('users', UserController::class);
// Route::resource('roles', RoleController::class);
