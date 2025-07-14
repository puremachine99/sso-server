<?php
namespace App\Http\Controllers;

use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user(); // Ambil user setelah berhasil login

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

        return back()->withErrors([
            'email' => 'Login gagal. Cek email dan password.',
        ]);
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
