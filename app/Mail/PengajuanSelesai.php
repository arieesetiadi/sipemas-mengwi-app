<?php

namespace App\Mail;

use App\Models\PengajuanSurat;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengajuanSelesai extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PengajuanSurat $pengajuan)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengajuan #' . $this->pengajuan->id . ' Selesai — Surat Siap Diunduh',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.pengajuan-selesai',
            with: [
                'tanggalSelesai' => $this->pengajuan->disetujui_pada->locale('id')->translatedFormat('j F Y, H:i'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
