<?php

use App\Mail\ExampleEmail;
use App\Mail\TestMailerSend;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testUserHcpm;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;


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
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1'); // 5 attempts per minute
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/logout-all', [AuthController::class, 'logoutAll'])->name('logout-all');

Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');


//test
Route::prefix('test')->group(function () {
    Route::get('/hcpm-users', [TestUserHcpm::class, 'index'])->name('hcpm.index');
    Route::get('/user/{id}', [TestUserHcpm::class, 'show'])->name('hcpm.show');
    Route::get('/users-with-roles', [TestUserHcpm::class, 'portalUser'])->name('portal.index');
    Route::get('/set-su/{email}', [TestUserHcpm::class, 'setSuperAdmin'])->name('portal.set-su');
    Route::get('/reset/{email}', [TestUserHcpm::class, 'resetPasswordToDefault'])->name('portal.reset');
    Route::get('/sync-hcpm', [TestUserHcpm::class, 'syncToPortal'])->name('test.hcpm.sync');
    Route::get('/email', function () {
        Mail::to('puremachine99@gmail.com')->send(new TestMailerSend());
        return 'Email test terkirim!';
    });
});