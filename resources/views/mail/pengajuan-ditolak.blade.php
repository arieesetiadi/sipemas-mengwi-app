<x-mail::message>
# Pengajuan Surat Ditolak

Mohon maaf, pengajuan surat Anda tidak dapat diproses.

**Detail Pengajuan:**
- No. Tiket: #{{ $pengajuan->id }}
- Jenis Surat: {{ $pengajuan->jenisSurat->label }}
- Diajukan pada: {{ $tanggalDiajukan }} WITA

**Alasan Penolakan:**

<x-mail::panel>
{{ $pengajuan->catatan_penolakan }}
</x-mail::panel>

Anda dapat mengajukan ulang setelah melengkapi persyaratan yang diminta.
Jika ada pertanyaan, silakan hubungi Kantor Prebekel Desa Adat Mengwi.

Terima kasih,
{{ config('app.name') }}
</x-mail::message>
