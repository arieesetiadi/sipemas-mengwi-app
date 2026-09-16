<x-mail::message>
# Pengajuan Surat Baru

Ada pengajuan surat baru yang membutuhkan tindakan Anda.

**Detail Pengajuan:**
- No. Tiket: #{{ $pengajuan->id }}
- Nama Pemohon: {{ $pengajuan->penduduk->nama }}
- NIK: {{ $pengajuan->penduduk->nik }}
- Jenis Surat: {{ $pengajuan->jenisSurat->label }}
- Diajukan pada: {{ $tanggalDiajukan }} WITA

Silakan buka dashboard SIPEMAS untuk memverifikasi pengajuan ini.

<x-mail::button :url="route('system.dashboard')">
Buka Dashboard
</x-mail::button>

Terima kasih,
{{ config('app.name') }}
</x-mail::message>
