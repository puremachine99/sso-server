<?php

use Illuminate\Support\Str;
use App\Mail\TestMailerSend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestUserHcpm;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Http\Exceptions\ThrottleRequestsException;


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

// Forgot password
Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])
    ->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->middleware('throttle:5,1') // max 5 request per menit
    ->name('password.email');
// Reset password
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
    ->name('password.update');
Route::get('/password/invalid', [PasswordResetController::class, 'invalid'])->name('password.invalid');
// test
Route::prefix('test')->group(function () {
    // Dashboard satu halaman
    Route::get('/dashboard', [TestUserHcpm::class, 'dashboard'])->name('test.index');

    // Yang lama tetap bisa diakses satuan:
    Route::get('/hcpm-users', [TestUserHcpm::class, 'index'])->name('hcpm.index');
    Route::get('/user/{id}', [TestUserHcpm::class, 'show'])->name('hcpm.show');
    Route::get('/users-with-roles', [TestUserHcpm::class, 'portalUser'])->name('portal.index');
    Route::get('/set-su/{email}', [TestUserHcpm::class, 'setSuperAdmin'])->name('portal.set-su');
    Route::get('/reset/{email}', [TestUserHcpm::class, 'resetPasswordToDefault'])->name('portal.reset');
    Route::get('/sync-hcpm', [TestUserHcpm::class, 'syncToPortal'])->name('test.hcpm.sync');

    // imgproxy tester
    Route::get('/test-imgproxy', function () {
        $path = 'images/bg-login.jpg';
        $url = imgproxy($path, '100x200,sc');
        return response()->json([
            'original' => config('services.imgproxy.base_asset_url') . '/' . ltrim($path, '/'),
            'imgproxy' => $url,
            'asset' => asset($path),
        ]);
    });

    // Error playground
    Route::get('/errors', fn() => view('test.errors'))->name('test.errors');
    Route::get('/error/404', fn() => abort(404, 'Testing 404'))->name('test.error.404');
    Route::get('/error/403', fn() => abort(403, 'Testing 403'))->name('test.error.403');
    Route::get('/error/401', fn() => abort(401, 'Testing 401'))->name('test.error.401');
    Route::match(['GET', 'POST'], '/error/419', fn() => throw new \Illuminate\Session\TokenMismatchException('Testing 419'))->name('test.error.419');
    Route::post('/error/422', function () {
        request()->validate(['email' => ['required', 'email']]);
        return 'ok';
    })->name('test.error.422');
    Route::get('/error/429', fn() => throw new \Illuminate\Http\Exceptions\ThrottleRequestsException('Testing 429'))->name('test.error.429');
    Route::get('/error/500', fn() => throw new \Exception('Testing 500'))->name('test.error.500');
    Route::get('/error/503', fn() => abort(503, 'Testing 503'))->name('test.error.503');
});

// Email tester (tetap di luar prefix)
Route::get('/test-reset-mail', function () {
    $to   = request('to', 'you@example.com');
    $name = request('name', 'Tester');
    $token = \Illuminate\Support\Str::random(64);
    $email = $to;

    $resetUrl = rtrim(config('app.url'), '/') . '/password/reset?token=' . $token . '&email=' . urlencode($email);

    $html = <<<HTML
<!doctype html>
<html><body style="font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif">
<h2>Reset password SmartID Portal</h2>
<p>Halo {$name}, klik tombol di bawah untuk buat password baru.</p>
<p style="margin:24px 0">
  <a href="{$resetUrl}" style="background:#0B57D0;color:#fff;text-decoration:none;padding:12px 18px;border-radius:8px;display:inline-block">Reset password</a>
</p>
<p>Link berlaku 60 menit. Jika bukan kamu yang minta, abaikan.</p>
<div style="font-size:12px;color:#666;margin-top:24px">Link langsung: <a href="{$resetUrl}">{$resetUrl}</a></div>
</body></html>
HTML;

    \Illuminate\Support\Facades\Mail::html($html, function ($m) use ($to) {
        $m->to($to)->subject('Reset password akun SmartID Portal');
    });

    return "OK. Cek inbox/spam: {$to}";
});
