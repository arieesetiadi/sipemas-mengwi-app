<x-mail::message>
# Pengajuan Surat Selesai

Pengajuan surat Anda telah selesai diproses. Surat sudah dapat diunduh melalui dashboard SIPEMAS.

**Detail Pengajuan:**
- No. Tiket: #{{ $pengajuan->id }}
- Jenis Surat: {{ $pengajuan->jenisSurat->label }}
- Nomor Surat: {{ $pengajuan->nomor_surat }}
- Selesai pada: {{ $tanggalSelesai }} WITA

<x-mail::button :url="route('portal.home')">
Buka Dashboard SIPEMAS
</x-mail::button>

Terima kasih,
{{ config('app.name') }}
</x-mail::message>
