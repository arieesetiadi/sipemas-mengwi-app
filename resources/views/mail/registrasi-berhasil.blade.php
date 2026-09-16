<x-mail::message>
# Selamat Datang, {{ $penduduk->nama }}!

Akun SIPEMAS Anda berhasil dibuat.

Akun ini dapat digunakan untuk mengajukan surat keterangan secara online dan memantau status pengajuan Anda tanpa perlu datang ke kantor desa.

**Detail Akun:**
- Nama: {{ $penduduk->nama }}
- Email: {{ $penduduk->email }}

Jika Anda merasa tidak pernah mendaftar di SIPEMAS, silakan abaikan email ini.

Terima kasih,
{{ config('app.name') }}
</x-mail::message>
