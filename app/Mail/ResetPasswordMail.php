<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $resetUrl;
    public ?string $userName;
    public int $expiryMinutes;

    public function __construct(string $resetUrl, ?string $userName = null, int $expiryMinutes = 60)
    {
        $this->resetUrl = $resetUrl;
        $this->userName = $userName;
        $this->expiryMinutes = $expiryMinutes;
    }

    public function build()
    {
        $this->from(config('mail.from.address'), 'Department Technology and AI SmartID')
            ->subject('Reset Password Akun SmartID');

        // Embed logo aman (tidak meledak kalau file tak ada)
        $logoCid = null;
        try {
            $path = public_path('images/smartid-logo.png'); // simpan file ini dari Google Drive ke sini
            if (is_file($path)) {
                $logoCid = $this->embedFromPath($path, 'logoSmartID'); // kembalikan "cid:..."
            }
        } catch (\Throwable $e) {
            Log::warning('Email logo embed failed: ' . $e->getMessage());
        }

        return $this->view('emails.reset_password', [
            'resetUrl'      => $this->resetUrl,
            'userName'      => $this->userDisplayName ?? $this->userName ?? null, // aman fallback
            'expiryMinutes' => $this->expiryMinutes,
            'logoCid'       => $logoCid,
        ])
            ->text('emails.reset_password_plain', [
                'resetUrl' => $this->resetUrl,
                'userName' => $this->userName,
                'expiryMinutes' => $this->expiryMinutes,
            ]);
    }
}
