<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\HcpmUser;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // ✅ 1. Coba login ke portal.users (Auth default)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user(); // Ambil user yang login

            // ⏺️ Logging
            LoginLog::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'app_code' => 'portal',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'logged_in_at' => now(),
                'login_type' => 'manual',
            ]);

            return redirect()->intended();
        }

        // ✅ 2. Kalau gagal, cek ke HCPM database
        /** ⛔ START: Login ke database HCPM */
        $hcpmUser = HcpmUser::with('jobDetail')->where('email', $request->email)->first();

        if (!$hcpmUser || !Hash::check($request->password, $hcpmUser->password)) {
            return back()->withErrors([
                'email' => 'Login gagal. Cek email dan password.',
            ]);
        }

        if (optional($hcpmUser->jobDetail)->employee_status !== 'Active') {
            return back()->withErrors([
                'email' => 'Akun Anda tidak aktif di sistem HCPM.',
            ]);
        }

        // Simpan user ke portal untuk bisa pakai Auth Laravel
        $user = User::firstOrCreate(
            ['email' => $hcpmUser->email],
            [
                'name' => $hcpmUser->name,
                'username' => $hcpmUser->username ?? null,
                'role' => $hcpmUser->role ?? 'employee',
                'department_id' => $hcpmUser->department_id,
                'password' => bcrypt($request->password), // agar bisa login ulang
            ]
        );
        /** ⛔ END: Login ke database HCPM */

        Auth::login($user);
        $request->session()->regenerate();

        // ⏺️ Logging
        LoginLog::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'app_code' => 'portal',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'logged_in_at' => now(),
            'login_type' => 'sso-db',
        ]);

        return redirect()->intended();
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($request->redirect_uri ?? '/login');
    }

    public function logoutAll(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $redirectUri = $request->query('redirect_uri', '/');

        return redirect($redirectUri);
    }
}
