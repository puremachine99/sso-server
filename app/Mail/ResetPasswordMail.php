<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
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
        return $this->subject('Reset password akun SmartID Portal')
            ->view('emails.reset_password', [
                'resetUrl' => $this->resetUrl,
                'userName' => $this->userName,
                'expiryMinutes' => $this->expiryMinutes,
            ])
            ->text('emails.reset_password_plain', [
                'resetUrl' => $this->resetUrl,
                'userName' => $this->userName,
                'expiryMinutes' => $this->expiryMinutes,
            ]);
    }
}
