<?php

namespace App\Http\Controllers;

use App\Models\HcpmUser;
use App\Models\User;
use App\Models\PasswordResetHcpm;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // Form input email
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim link reset ke email
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = HcpmUser::where('email', $request->email)->first();

        // Selalu balas netral (anti user-enumeration)
        $genericMessage = __('Jika email terdaftar, tautan reset password telah dikirim.');

        if (! $user) {
            return back()->with('status', $genericMessage);
        }

        // generate token raw
        $rawToken = Str::random(64);
        $hash = hash('sha256', $rawToken);

        PasswordResetHcpm::create([
            'email'      => $user->email,
            'token_hash' => $hash,
            'expires_at' => Carbon::now()->addMinutes(60),
        ]);

        // Buat URL reset
        $resetUrl = route('password.reset', [
            'token' => $rawToken,
            'email' => $user->email,
        ]);

        // Kirim email
        Mail::to($user->email)->send(
            new ResetPasswordMail($resetUrl, $user->name ?? null, 60)
        );

        return back()->with('status', $genericMessage);
    }

    // Tampilkan form reset
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email'); // ambil dari query string
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $record = PasswordResetHcpm::where('email', $request->email)
            ->where('used', false)
            ->latest()
            ->first();

        if (! $record) {
            return back()->withErrors([
                'email' => __('Token tidak valid atau sudah digunakan.'),
            ]);
        }

        $isValid = hash_equals(
            $record->token_hash,
            hash('sha256', $request->token)
        );

        if (! $isValid || now()->greaterThan($record->expires_at)) {
            return back()->withErrors([
                'email' => __('Token tidak valid atau sudah kedaluwarsa.'),
            ]);
        }

        // hash password baru
        $hashedPassword = Hash::make($request->password);

        // update password user di DB HCPM
        $userHcpm = HcpmUser::where('email', $request->email)->first();
        if ($userHcpm) {
            $userHcpm->update(['password' => $hashedPassword]);
        }

        // update juga password user di Portal (jika ada)
        $userPortal = User::where('email', $request->email)->first();
        if ($userPortal) {
            $userPortal->update(['password' => $hashedPassword]);
        }

        // tandai token sudah dipakai
        $record->update(['used' => true]);

        return redirect()->route('login')->with(
            'status',
            __('Password berhasil direset. Silakan login dengan password baru.')
        );
    }
}
