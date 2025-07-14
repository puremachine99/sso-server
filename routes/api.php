<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    $user = $request->user();

    // Ambil semua user dengan email yang sama
    $linked = User::where('email', $user->email)
        ->get()
        ->map(function ($u) {
            return [
                'app' => $u->app_code ?? 'unknown', // pastikan ada kolom 'app_code' di table 'users'
                'role' => $u->role ?? 'user',
            ];
        });

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'linked_accounts' => $linked,
    ]); 
});
