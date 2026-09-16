<x-mail::message>
# Pengajuan Surat Diverifikasi

Berkas pengajuan surat Anda sudah diverifikasi oleh petugas dan saat ini menunggu persetujuan Sekretaris/Perbekel. Status pengajuan dapat Anda pantau melalui dashboard SIPEMAS.

**Detail Pengajuan:**
- No. Tiket: #{{ $pengajuan->id }}
- Jenis Surat: {{ $pengajuan->jenisSurat->label }}
- Diajukan pada: {{ $tanggalDiajukan }} WITA

<x-mail::button :url="route('portal.home')">
Buka Dashboard SIPEMAS
</x-mail::button>

Terima kasih,
{{ config('app.name') }}
</x-mail::message>
