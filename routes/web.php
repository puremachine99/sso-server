<?php

use App\Http\Controllers\testUserHcpm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Mail;


// Redirect '/' ke login jika belum login, atau ke dashboard jika sudah login
Route::get('/', function () {
    return Auth::check()
        ? redirect('/dashboard') // ganti sesuai nama dashboard route kamu
        : redirect('/admin/login');
});

// Override Filament login route
Route::get('/login', function () {
    return Auth::check()
        ? redirect('/dashboard') // jika sudah login, lempar ke dashboard
        : redirect('/admin/login');     // jika belum, redirect ke login custom
});

//overide filament login route 
Route::get('/login', fn() => redirect('/admin/login'));
Route::get('/dashboard/login', fn() => redirect('/admin/login'));
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1'); // 5 attempts per minute
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/logout-all', [AuthController::class, 'logoutAll'])->name('logout-all');

Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');


//test
Route::get('/test/hcpm-users', [testUserHcpm::class, 'index']);
Route::get('/user/{id}', [testUserHcpm::class, 'show'])->name('user.show');
Route::get('/test/users-with-roles', [TestUserHcpm::class, 'portalUser']);
Route::get('/test/set-su/{email}', [TestUserHcpm::class, 'setSuperAdmin']);