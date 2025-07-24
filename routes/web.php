<?php

use App\Http\Controllers\testUserHcpm;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});
//overide filament login route 
Route::get('/login', fn() => redirect('/admin/login'));
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
