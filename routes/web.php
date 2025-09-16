<?php

use App\Mail\TestMailerSend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestUserHcpm;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;


// Root: kirim ke dashboard kalau sudah login, kalau belum ke /admin/login
Route::get('/', fn() => Auth::check() ? redirect('/dashboard') : redirect()->route('admin.login'));

// Sediakan alias bernama 'login' agar middleware senang
Route::get('/login', fn() => redirect()->route('admin.login'))->name('login');

// Halaman login custom
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');

// Logout
Route::post('/dashboard/logout', [AuthController::class, 'logout'])
    ->name('filament.admin.auth.logout')
    ->withoutMiddleware([\Filament\Http\Middleware\Authenticate::class]);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout-all', [AuthController::class, 'logoutAll'])->name('logout-all');

// Forgot/reset password
Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->middleware('throttle:5,1')
    ->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
// test
Route::prefix('test')->group(function () {
    Route::get('/hcpm-users', [TestUserHcpm::class, 'index'])->name('hcpm.index');
    Route::get('/user/{id}', [TestUserHcpm::class, 'show'])->name('hcpm.show');
    Route::get('/users-with-roles', [TestUserHcpm::class, 'portalUser'])->name('portal.index');
    Route::get('/set-su/{email}', [TestUserHcpm::class, 'setSuperAdmin'])->name('portal.set-su');
    Route::get('/reset/{email}', [TestUserHcpm::class, 'resetPasswordToDefault'])->name('portal.reset');
    Route::get('/sync-hcpm', [TestUserHcpm::class, 'syncToPortal'])->name('test.hcpm.sync');

    // mail test
    Route::get('/email', function () {
        Mail::to('puremachine99@gmail.com')->send(new TestMailerSend());
        return 'Email test terkirim!';
// hehe
    });

    //imgproxy
    Route::get('/test-imgproxy', function () {
        $path = 'images/bg-login.jpg';

        $url = imgproxy($path, '100x200,sc');

        return response()->json([
            'original' => config('services.imgproxy.base_asset_url') . '/' . ltrim($path, '/'),
            'imgproxy' => $url,
            'asset' => asset($path),
        ]);
    });
});
