@use('App\Enums\JenisKelamin')
@use('Illuminate\Support\Carbon')
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<style>
    body { font-family: "Times New Roman", Times, serif; font-size: 12pt; line-height: 1.5; margin: 40px; }
    .kop { text-align: center; font-weight: bold; }
    .kop p { margin: 2px 0; }
    .garis-kop { border-bottom: 3px double #000; margin: 12px 0 20px; }
    .judul { text-align: center; font-weight: bold; text-decoration: underline; margin: 16px 0 12px; }
    table.field { width: 100%; border-collapse: collapse; }
    table.field td { padding: 3px 0; vertical-align: top; }
    td.kiri { width: 180px; }
    .ttd { margin-top: 56px; text-align: right; }
    .ttd p { margin: 2px 0; }
</style>
</head>
<body>
@php
    $penduduk = $pengajuan->penduduk;
    $ttl = $penduduk->tempat_lahir . ', ' . Carbon::parse($penduduk->tanggal_lahir)->locale('id')->translatedFormat('d F Y');
@endphp

<div class="kop">
    <p>PEMERINTAH KABUPATEN BADUNG</p>
    <p>KECAMATAN MENGWI</p>
    <p>DESA ADAT MENGWI</p>
</div>
<div class="garis-kop"></div>

<div class="judul">SURAT KETERANGAN DOMISILI</div>
<p style="margin: 0 0 12px;">Nomor: {{ $pengajuan->nomor_surat }}</p>

<p>Yang bertanda tangan di bawah ini Perbekel Desa Adat Mengwi, Kecamatan Mengwi, Kabupaten Badung, menerangkan dengan sebenarnya bahwa:</p>

<table class="field">
    <tr><td class="kiri">Nama</td><td>: {{ $penduduk->nama }}</td></tr>
    <tr><td class="kiri">Tempat, Tanggal Lahir</td><td>: {{ $ttl }}</td></tr>
    <tr><td class="kiri">Jenis Kelamin</td><td>: {{ JenisKelamin::from($penduduk->jenis_kelamin)->label() }}</td></tr>
    <tr><td class="kiri">Status Perkawinan</td><td>: {{ $pengajuan->status_perkawinan?->value ?? '-' }}</td></tr>
    <tr><td class="kiri">Agama</td><td>: {{ $penduduk->agama }}</td></tr>
    <tr><td class="kiri">Pekerjaan</td><td>: {{ $penduduk->pekerjaan }}</td></tr>
    <tr><td class="kiri">Alamat</td><td>: {{ $penduduk->alamat }}</td></tr>
</table>

<p>Orang tersebut di atas adalah betul penduduk Desa Adat Mengwi dan berdomisili di alamat tersebut di atas. Oleh karena itu kepada yang berkepentingan dimohon untuk menjadi tahu dan maklum serta melancarkan dalam permasalahannya.</p>

<p>Demikian surat keterangan ini kami buat dengan sebenarnya dan untuk dipergunakan seperlunya.</p>

<div class="ttd">
    <p>Mengwi, {{ $tanggalSurat }}</p>
    <p>Perbekel Desa Adat Mengwi</p>
    <p style="margin-top: 64px;">{{ $perbekelNama }}</p>
</div>
</body>
</html>
