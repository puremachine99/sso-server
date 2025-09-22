<?php

namespace App\Http\Controllers;

use App\Models\HcpmUser;
use App\Models\User;
use App\Models\PasswordResetHcpm;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;


class PasswordResetController extends Controller
{
    // === STEP 1: Form input email ===
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    // === STEP 2: Kirim link reset ke email (selalu balas netral) ===
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = HcpmUser::where('email', $request->email)->first();

        // Balasan netral (anti user-enumeration)
        $genericMessage = __('Jika email terdaftar, tautan reset password sudah kami kirim ke email Anda. Silakan cek kotak masuk atau folder spam.');

        if (! $user) {
            return back()->with('status', $genericMessage);
        }

        // Generate token satu kali pakai
        $rawToken = Str::random(64);
        $hash     = hash('sha256', $rawToken);

        PasswordResetHcpm::create([
            'email'      => $user->email,
            'token_hash' => $hash,
            'expires_at' => now()->addMinutes(60),
        ]);

        // URL reset (token raw + email)
        $resetUrl = route('password.reset', [
            'token' => $rawToken,
            'email' => $user->email,
        ]);

        // Kirim email (log error bila gagal, tapi balasan tetap netral)
        try {
            Mail::to($user->email)->send(
                new ResetPasswordMail($resetUrl, $user->name ?? null, 60)
            );
        } catch (\Throwable $e) {
            Log::error('Reset mail failed: ' . $e->getMessage(), ['email' => $user->email]);
            // Tetap balas netral ke user
        }


        return back()->with('status', $genericMessage);
    }

    // === Helper: ambil record token yang MASIH valid (belum used & belum expired & hash cocok) ===
    protected function getValidResetRecord(string $email, string $rawToken): ?PasswordResetHcpm
    {
        $record = PasswordResetHcpm::where('email', $email)
            ->where('used', false)
            ->latest() // ambil token terbaru untuk email tsb
            ->first();

        if (! $record) {
            return null;
        }

        $match      = hash_equals($record->token_hash, hash('sha256', $rawToken));
        $notExpired = now()->lessThanOrEqualTo($record->expires_at);

        return ($match && $notExpired) ? $record : null;
    }

    // === STEP 3: Tampilkan form reset - HANYA jika token valid ===
    public function showResetForm(Request $request, string $token)
    {
        $email = (string) $request->query('email');

        // Cek validitas token saat pertama kali diakses
        $record = ($email !== '') ? $this->getValidResetRecord($email, $token) : null;
        if (! $record) {
            return redirect()->route('password.invalid');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    // === STEP 4: Proses reset password - validasi token lagi (server-side) ===
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        // Validasi ulang token (single-use + expiry + hash match)
        $record = $this->getValidResetRecord($request->email, $request->token);
        if (! $record) {
            return redirect()->route('password.invalid');
        }

        $hashedPassword = Hash::make($request->password);

        // Update password di DB HCPM
        $userHcpm = HcpmUser::where('email', $request->email)->first();
        if ($userHcpm) {
            $userHcpm->update(['password' => $hashedPassword]);
        }

        // Update password di Portal (jika user ada)
        $userPortal = User::where('email', $request->email)->first();
        if ($userPortal) {
            $userPortal->update(['password' => $hashedPassword]);
        }

        // Tandai token sudah digunakan → single-use
        $record->update(['used' => true]);

        return redirect()->route('login')->with(
            'status',
            __('Password berhasil direset. Silakan login dengan password baru.')
        );
    }

    // === STEP 5: Halaman invalid token ===
    public function invalid()
    {
        return view('auth.reset-invalid');
    }
}
