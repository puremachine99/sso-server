<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        // Selalu balas netral untuk menghindari user-enumeration
        // (kita tidak bocorkan apakah email terdaftar atau tidak)
        return back()->with(
            'status',
            __('Jika email terdaftar, tautan reset password telah dikirim.')
        );
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Opsional: Revoke semua personal access tokens (Passport)
                if (method_exists($user, 'tokens')) {
                    try {
                        $user->tokens()->delete();
                    } catch (\Throwable $e) {
                        // Abaikan jika Passport tidak aktif
                    }
                }
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            // Tampilkan pesan sukses generik
            return redirect()->route('login')->with(
                'status',
                __('Password berhasil direset. Silakan login dengan password baru.')
            );
        }

        // Pesan gagal tetap generik agar tidak bocor konteks token/email
        return back()->withErrors([
            'email' => [__('Gagal mereset password. Tautan mungkin tidak valid atau telah kedaluwarsa.')],
        ]);
    }
}
