<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleEntryController;
use Illuminate\Support\Facades\Route;

Route::get('/page', function () {
    return view('welcome');
});

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('vehicle-entry')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserController::class, 'login']);

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

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');
    Route::get('/dashboard/chart', [DashboardController::class, 'chart'])->name('dashboard.chart');

    // Protected routes
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/vehicle-entry', [VehicleEntryController::class, 'index'])->name('vehicle-entry');
    Route::get('/vehicle-entries', [VehicleEntryController::class, 'index'])->name('vehicle-entries.index');
    Route::post('/vehicle-entries', [VehicleEntryController::class, 'store'])->name('vehicle-entries.store');
    Route::get('/vehicle-entries/{id}/pdf', [VehicleEntryController::class, 'pdf'])->name('vehicle-entries.pdf');
});
// Route::resource('users', UserController::class);
// Route::resource('roles', RoleController::class);
