<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});
//overide filament login route
Route::get('/login', fn() => redirect('/admin/login'));
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1'); // 5 attempts per minute
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/logout-all', [AuthController::class, 'logoutAll'])->name('logout-all');
