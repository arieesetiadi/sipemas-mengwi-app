@extends('system.layouts.layout')

@use('App\Enums\JenisKelamin')
@use('App\Enums\StatusSurat')
@use('Illuminate\Support\Carbon')

@php
    $penduduk = $pengajuan->penduduk;
    $jenisSurat = $pengajuan->jenisSurat;
@endphp

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex justify-content-between align-items-center">
                        <h1>Tinjau Pengajuan</h1>
                        <a href="{{ route('system.pengajuan.index') }}" class="btn btn-light">
                            <i class="material-icons">arrow_back</i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div>
                                <h5 class="mb-1">{{ $jenisSurat?->label ?? '-' }}</h5>
                                <small class="text-muted">Kode: {{ $jenisSurat?->kode ?? '-' }} ·
                                    Diajukan {{ $pengajuan->created_at?->format('d M Y H:i') }}</small>
                            </div>
                            <span class="badge {{ $pengajuan->status->badgeClass() }} fs-6 px-3 py-2"
                                @if ($pengajuan->status->keterangan()) data-bs-toggle="tooltip" title="{{ $pengajuan->status->keterangan() }}" @endif>
                                {{ $pengajuan->status->value }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Data Pemohon</h6>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Nama</small>
                                    <strong>{{ $penduduk?->nama ?? '-' }}</strong>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">NIK</small>
                                    <strong>{{ $penduduk?->nik ?? '-' }}</strong>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Jenis Kelamin</small>
                                    <strong>{{ $penduduk ? JenisKelamin::from($penduduk->jenis_kelamin)->label() : '-' }}</strong>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Tempat, Tgl Lahir</small>
                                    <strong>
                                        @if ($penduduk)
                                            {{ $penduduk->tempat_lahir }},
                                            {{ Carbon::parse($penduduk->tanggal_lahir)->format('d-m-Y') }}
                                        @else
                                            -
                                        @endif
                                    </strong>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Agama</small>
                                    <strong>{{ $penduduk?->agama ?? '-' }}</strong>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Pekerjaan</small>
                                    <strong>{{ $penduduk?->pekerjaan ?? '-' }}</strong>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Banjar</small>
                                    <strong>{{ $penduduk?->banjar?->label ?? '-' }}</strong>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Telepon</small>
                                    <strong>{{ $penduduk?->telepon ?? '-' }}</strong>
                                </div>
                                <div class="col-12 mb-2">
                                    <small class="text-muted d-block">Alamat</small>
                                    <strong>{{ $penduduk?->alamat ?? '-' }}</strong>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block">Email</small>
                                    <strong>{{ $penduduk?->email ?? '-' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Detail Pengajuan</h6>

                            @if ($jenisSurat && $jenisSurat->kode === 'SKD')
                                <div class="mb-2">
                                    <small class="text-muted d-block">Status Perkawinan</small>
                                    <strong>{{ $pengajuan->status_perkawinan?->value ?? '-' }}</strong>
                                </div>
                            @elseif ($jenisSurat && $jenisSurat->kode === 'SKU')
                                <div class="mb-2">
                                    <small class="text-muted d-block">Nama Usaha</small>
                                    <strong>{{ $pengajuan->nama_usaha ?? '-' }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Lokasi Usaha</small>
                                    <strong>{{ $pengajuan->lokasi_usaha ?? '-' }}</strong>
                                </div>
                            @elseif ($jenisSurat && $jenisSurat->kode === 'SP')
                                <div class="mb-2">
                                    <small class="text-muted d-block">Tujuan Instansi</small>
                                    <strong>{{ $pengajuan->tujuan_instansi ?? '-' }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Keperluan</small>
                                    <strong>{{ $pengajuan->keperluan ?? '-' }}</strong>
                                </div>
                            @endif

                            @if ($pengajuan->catatan)
                                <div class="mb-2">
                                    <small class="text-muted d-block">Catatan Pemohon</small>
                                    <strong>{{ $pengajuan->catatan }}</strong>
                                </div>
                            @endif

                            @if ($pengajuan->nomor_surat)
                                <div class="mb-2">
                                    <small class="text-muted d-block">Nomor Surat</small>
                                    <strong>{{ $pengajuan->nomor_surat }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Lampiran</h6>
                            @forelse ($pengajuan->lampiran as $lampiran)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ $lampiran->jenis_lampiran->value }}</span>
                                    <a href="{{ route('system.pengajuan.lampiran', [$pengajuan, $lampiran]) }}"
                                        target="_blank" class="btn btn-sm btn-light">
                                        <i class="material-icons">visibility</i> Lihat
                                    </a>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Tidak ada lampiran.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Riwayat Proses</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <span class="badge bg-warning me-2">Diajukan</span>
                                    {{ $pengajuan->created_at?->format('d M Y H:i') }}
                                </li>

                                @if ($pengajuan->diverifikasi_pada)
                                    <li class="mb-2">
                                        <span class="badge bg-primary me-2">Diverifikasi</span>
                                        oleh {{ $pengajuan->diverifikasiOleh?->nama ?? '-' }}
                                        pada {{ $pengajuan->diverifikasi_pada->format('d M Y H:i') }}
                                    </li>
                                @endif

                                @if ($pengajuan->status === StatusSurat::Ditolak)
                                    <li class="mb-2">
                                        <span class="badge bg-danger me-2">Ditolak</span>
                                        oleh {{ $pengajuan->ditolakOleh?->nama ?? '-' }}
                                        pada {{ $pengajuan->ditolak_pada?->format('d M Y H:i') }}
                                    </li>
                                    <li class="mb-0">
                                        <small class="text-muted d-block">Catatan Penolakan</small>
                                        <strong>{{ $pengajuan->catatan_penolakan ?? '-' }}</strong>
                                    </li>
                                @endif

                                @if ($pengajuan->status === StatusSurat::Selesai)
                                    <li class="mb-2">
                                        <span class="badge bg-success me-2">Selesai</span>
                                        oleh {{ $pengajuan->disetujuiOleh?->nama ?? '-' }}
                                        pada {{ $pengajuan->disetujui_pada?->format('d M Y H:i') }}
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                @if (($isStaf && $pengajuan->status === StatusSurat::Diajukan) || ($isPimpinan && $pengajuan->status === StatusSurat::Diverifikasi))
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-wrap gap-2">
                                @if ($isStaf && $pengajuan->status === StatusSurat::Diajukan)
                                    <form method="POST" action="{{ route('system.pengajuan.verifikasi', $pengajuan) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">
                                            <i class="material-icons">check</i> Verifikasi
                                        </button>
                                    </form>
                                @endif

                                @if ($isPimpinan && $pengajuan->status === StatusSurat::Diverifikasi)
                                    <form method="POST" action="{{ route('system.pengajuan.selesai', $pengajuan) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">
                                            <i class="material-icons">check</i> Setujui & Terbitkan
                                        </button>
                                    </form>
                                @endif

                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#tolakModal">
                                    <i class="material-icons">close</i> Tolak
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- modal tolak --}}
    <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('system.pengajuan.tolak', $pengajuan) }}">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="tolakModalLabel">Tolak Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="catatan_penolakan" class="form-label required">Catatan Penolakan</label>
                        <textarea name="catatan_penolakan" id="catatan_penolakan" rows="3" maxlength="255"
                            class="form-control" placeholder="Alasan pengajuan ditolak" required>{{ old('catatan_penolakan') }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
