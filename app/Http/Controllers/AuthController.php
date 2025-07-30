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

        // ✅ 1. Cek apakah user ada di database PORTAL
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            LoginLog::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'app_code' => 'portal',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'logged_in_at' => now(),
                'login_type' => 'local-db',
            ]);

            return redirect()->intended();
        }

        // ✅ 2. Jika tidak ditemukan, coba cek user di database HCPM
        $hcpmUser = \App\Models\HcpmUser::with('jobDetail')->where('email', $request->email)->first();

        if (!$hcpmUser || !Hash::check($request->password, $hcpmUser->password)) {
            return back()->withErrors([
                'email' => 'Login gagal. Cek email dan password.',
            ]);
        }

        if ($hcpmUser->status !== 'Active') {
            return back()->withErrors([
                'email' => 'Akun Anda tidak aktif. Hanya karyawan berstatus Active yang dapat login.',
            ]);
        }

        // ✅ 3. Jika dari HCPM valid, login pakai akun temporary (tanpa simpan di portal.users)
        $tempUser = new \App\Models\User([
            'name' => $hcpmUser->name,
            'email' => $hcpmUser->email,
            'username' => $hcpmUser->username ?? null,
            'role' => $hcpmUser->role ?? 'employee',
            'department_id' => $hcpmUser->department_id,
        ]);
        $tempUser->id = -1; // set fake ID agar tidak bentrok di relasi
        Auth::login($tempUser);

        // (OPSIONAL) Kalau mau simpan ke portal.users, uncomment ini
        /*
        $user = User::firstOrCreate(
            ['email' => $hcpmUser->email],
            [
                'name' => $hcpmUser->name,
                'username' => $hcpmUser->username ?? null,
                'role' => $hcpmUser->role,
                'department_id' => $hcpmUser->department_id,
                'password' => bcrypt(Str::random(40)),
            ]
        );
        Auth::login($user);
        */

        LoginLog::create([
            'user_id' => null, // karena bukan user portal
            'email' => $hcpmUser->email,
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
