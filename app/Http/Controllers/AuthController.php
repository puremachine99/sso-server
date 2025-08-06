<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HcpmUser;
use App\Models\LoginLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     // 1️⃣ Cari di portal dulu (users lokal)
    //     $localUser = User::where('email', $request->email)->first();

    //     if ($localUser && Hash::check($request->password, $localUser->password)) {
    //         // Login biasa (manual account)
    //         Auth::login($localUser);
    //         $request->session()->regenerate();

    //         LoginLog::create([
    //             'user_id' => $localUser->id,
    //             'email' => $localUser->email,
    //             'app_code' => 'portal',
    //             'ip_address' => $request->ip(),
    //             'user_agent' => $request->userAgent(),
    //             'logged_in_at' => now(),
    //             'login_type' => 'manual',
    //         ]);

    //         return redirect()->intended();
    //     }

    //     // 2️⃣ Jika tidak ada di portal atau password salah, cek ke HCPM
    //     $hcpmUser = HcpmUser::with('jobDetail')->where('email', $request->email)->first();

    //     if (!$hcpmUser || !Hash::check($request->password, $hcpmUser->password)) {
    //         return back()->withErrors([
    //             'email' => 'Login gagal. Cek email dan password.',
    //         ]);
    //     }

    //     if ($hcpmUser->status !== 'Active') {
    //         return back()->withErrors([
    //             'email' => 'Akun Anda tidak aktif. Hanya karyawan berstatus Active yang dapat login.',
    //         ]);
    //     }

    //     // Cari atau buat user berdasarkan email dari HCPM
    //     $user = User::firstOrNew(['email' => $hcpmUser->email]);

    //     $isNew = !$user->exists;

    //     if ($isNew) {
    //         $user->fill([
    //             'name' => $hcpmUser->name,
    //             'username' => $hcpmUser->username ?? null,
    //             'department_id' => $hcpmUser->department_id,
    //             'password' => bcrypt(Str::random(40)), // placeholder password
    //             'source' => 'synced user',
    //         ])->save();
    //     }

    //     // Hanya assign role jika user baru ATAU belum punya role sama sekali
    //     if ($isNew || !$user->roles()->exists()) {
    //         if ($user->email === 'puremachine99@gmail.com') {
    //             $user->syncRoles(['super_admin']);
    //         } else {
    //             $user->syncRoles(['smartnakama']);
    //         }
    //     }

    //     Auth::login($user);
    //     $request->session()->regenerate();

    //     LoginLog::create([
    //         'user_id' => $user->id,
    //         'email' => $user->email,
    //         'app_code' => 'portal',
    //         'ip_address' => $request->ip(),
    //         'user_agent' => $request->userAgent(),
    //         'logged_in_at' => now(),
    //         'login_type' => 'sso-db',
    //     ]);

    //     return redirect()->intended();
    // }


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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (
            !$user ||
            !Hash::check($request->password, $user->password) ||
            $user->hcpm_status === 'Terminated'
        ) {
            return back()->withErrors([
                'email' => 'Login gagal. Cek email, password, dan status akun Anda.',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

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

}
