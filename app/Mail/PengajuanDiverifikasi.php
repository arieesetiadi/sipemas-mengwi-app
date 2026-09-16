<?php

namespace App\Mail;

use App\Models\PengajuanSurat;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengajuanDiverifikasi extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PengajuanSurat $pengajuan)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengajuan #' . $this->pengajuan->id . ' Diverifikasi',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.pengajuan-diverifikasi',
            with: [
                'tanggalDiajukan' => $this->pengajuan->created_at->locale('id')->translatedFormat('j F Y, H:i'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
