<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class TestMailerSend extends Mailable
{
    use Queueable, SerializesModels;

    public $appName;
    public $previewText;
    public $bodyMessage;

    public function __construct()
    {
        $this->appName = config('app.name');
        $this->previewText = 'Pengujian pengiriman email melalui MailerSend API.';
        $this->bodyMessage = 'Selamat! Email ini berhasil dikirim melalui MailerSend API dengan integrasi Laravel.';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Pengujian Email - {$this->appName}"
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'test.test-mail',
            with: [
                'appName'     => $this->appName,
                'previewText' => $this->previewText,
                'bodyMessage' => $this->bodyMessage,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
