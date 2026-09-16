<?php

namespace App\Mail;

use App\Models\Penduduk;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrasiBerhasil extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Penduduk $penduduk)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat Datang di SIPEMAS',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.registrasi-berhasil',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
