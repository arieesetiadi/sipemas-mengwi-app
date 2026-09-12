@extends('portal.layouts.layout')

@use('App\Enums\JenisKelamin')
@use('App\Enums\StatusPerkawinan')
@use('Illuminate\Support\Carbon')

@php
    $penduduk = auth('portal')->user();
    $jkLabel = JenisKelamin::from($penduduk->jenis_kelamin)->label();
    $pengajuan = $pengajuan ?? null;
    $isEdit = $pengajuan !== null;
@endphp

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex justify-content-between align-items-center">
                        <h1>{{ $isEdit ? 'Ajukan Ulang' : 'Ajukan' }} {{ $jenisSurat->label }}</h1>
                        <a href="{{ route('portal.home') }}" class="btn btn-light">
                            <i class="material-icons">arrow_back</i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form id="pengajuan-form"
                        action="{{ $isEdit ? route('portal.pengajuan.update', $pengajuan) : route('portal.pengajuan.store', $jenisSurat) }}"
                        method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        @if ($isEdit)
                            @method('PATCH')
                        @endif

                        <h6 class="fw-bold mb-3">Data Pemohon</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="data-nama" class="form-label">Nama</label>
                                <input type="text" id="data-nama" class="form-control" value="{{ $penduduk->nama }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="data-nik" class="form-label">NIK</label>
                                <input type="text" id="data-nik" class="form-control" value="{{ $penduduk->nik }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="data-jk" class="form-label">Jenis Kelamin</label>
                                <input type="text" id="data-jk" class="form-control" value="{{ $jkLabel }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="data-ttl" class="form-label">Tempat, Tgl Lahir</label>
                                <input type="text" id="data-ttl" class="form-control"
                                    value="{{ $penduduk->tempat_lahir }}, {{ Carbon::parse($penduduk->tanggal_lahir)->format('d-m-Y') }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="data-agama" class="form-label">Agama</label>
                                <input type="text" id="data-agama" class="form-control" value="{{ $penduduk->agama }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="data-pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" id="data-pekerjaan" class="form-control"
                                    value="{{ $penduduk->pekerjaan }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="data-banjar" class="form-label">Banjar</label>
                                <input type="text" id="data-banjar" class="form-control"
                                    value="{{ $penduduk->banjar?->label ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="data-alamat" class="form-label">Alamat</label>
                                <input type="text" id="data-alamat" class="form-control" value="{{ $penduduk->alamat }}"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="data-telepon" class="form-label">Telepon</label>
                                <input type="text" id="data-telepon" class="form-control"
                                    value="{{ $penduduk->telepon ?? '-' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="data-email" class="form-label">Email</label>
                                <input type="text" id="data-email" class="form-control" value="{{ $penduduk->email }}"
                                    readonly>
                            </div>
                        </div>

                        <hr class="my-5">

                        <h6 class="fw-bold mb-3">Detail Pengajuan</h6>

                        @if ($jenisSurat->kode === 'SKD')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="status_perkawinan" class="form-label required">Status Perkawinan</label>
                                    <select name="status_perkawinan" id="status_perkawinan"
                                        class="form-select @error('status_perkawinan') is-invalid @enderror" required>
                                        <option value="">-- Pilih Status Perkawinan --</option>
                                        @foreach (StatusPerkawinan::cases() as $status)
                                            <option value="{{ $status->value }}"
                                                {{ old('status_perkawinan', $pengajuan?->status_perkawinan?->value) == $status->value ? 'selected' : '' }}>
                                                {{ $status->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_perkawinan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        @if ($jenisSurat->kode === 'SKU')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_usaha" class="form-label required">Nama Usaha</label>
                                    <input type="text" name="nama_usaha" id="nama_usaha"
                                        class="form-control @error('nama_usaha') is-invalid @enderror"
                                        value="{{ old('nama_usaha', $pengajuan?->nama_usaha ?? '') }}"
                                        placeholder="Nama usaha Anda" maxlength="255" required>
                                    @error('nama_usaha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="lokasi_usaha" class="form-label required">Lokasi Usaha</label>
                                    <input type="text" name="lokasi_usaha" id="lokasi_usaha"
                                        class="form-control @error('lokasi_usaha') is-invalid @enderror"
                                        value="{{ old('lokasi_usaha', $pengajuan?->lokasi_usaha ?? '') }}"
                                        placeholder="Alamat lokasi usaha" maxlength="255" required>
                                    @error('lokasi_usaha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        @if ($jenisSurat->kode === 'SP')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="tujuan_instansi" class="form-label required">Tujuan Instansi</label>
                                    <input type="text" name="tujuan_instansi" id="tujuan_instansi"
                                        class="form-control @error('tujuan_instansi') is-invalid @enderror"
                                        value="{{ old('tujuan_instansi', $pengajuan?->tujuan_instansi ?? '') }}"
                                        placeholder="Nama instansi tujuan" maxlength="255" required>
                                    @error('tujuan_instansi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="keperluan" class="form-label required">Keperluan</label>
                                    <input type="text" name="keperluan" id="keperluan"
                                        class="form-control @error('keperluan') is-invalid @enderror"
                                        value="{{ old('keperluan', $pengajuan?->keperluan ?? '') }}"
                                        placeholder="Keperluan pengajuan" maxlength="255" required>
                                    @error('keperluan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        {{-- <div class="mt-3">
                                    <label for="catatan" class="form-label">Catatan <span class="text-muted">(opsional)</span></label>
                                    <textarea name="catatan" id="catatan" rows="2"
                                        class="form-control @error('catatan') is-invalid @enderror"
                                        placeholder="Catatan tambahan bila ada">{{ old('catatan') }}</textarea>
                                    @error('catatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                        <hr class="my-5">

                        <h6 class="fw-bold mb-3">Lampiran</h6>

                        @if ($isEdit && $pengajuan->lampiran->isNotEmpty())
                            <div class="mb-4">
                                <small class="text-muted d-block mb-2">Lampiran saat ini:</small>
                                @foreach ($pengajuan->lampiran as $lampiran)
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge bg-dark">{{ $lampiran->jenis_lampiran->value }}</span>
                                        <a href="{{ route('portal.pengajuan.lampiran', [$pengajuan, $lampiran]) }}"
                                            target="_blank" class="btn btn-sm btn-light">
                                            <i class="material-icons">visibility</i> Lihat
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="lampiran_ktp" class="form-label {{ $isEdit ? '' : 'required' }}">KTP</label>
                                <input type="file" name="lampiran_ktp" id="lampiran_ktp" accept=".jpg,.jpeg,.png,.pdf"
                                    class="form-control @error('lampiran_ktp') is-invalid @enderror"
                                    {{ $isEdit ? '' : 'required' }}>
                                @if ($isEdit)
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah.</small>
                                @endif
                                @error('lampiran_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="lampiran_kk" class="form-label {{ $isEdit ? '' : 'required' }}">Kartu Keluarga (KK)</label>
                                <input type="file" name="lampiran_kk" id="lampiran_kk" accept=".jpg,.jpeg,.png,.pdf"
                                    class="form-control @error('lampiran_kk') is-invalid @enderror"
                                    {{ $isEdit ? '' : 'required' }}>
                                @if ($isEdit)
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah.</small>
                                @endif
                                @error('lampiran_kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex mt-5 gap-2">
                            <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Ajukan Ulang' : 'Kirim Pengajuan' }}</button>
                            <a href="{{ route('portal.home') }}" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/jquery-validate/jquery.validate.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#pengajuan-form').validate({
                rules: {
                    @if ($jenisSurat->kode === 'SKD')
                        status_perkawinan: {
                            required: true
                        },
                    @elseif ($jenisSurat->kode === 'SKU')
                        nama_usaha: {
                                required: true,
                                maxlength: 255
                            },
                            lokasi_usaha: {
                                required: true,
                                maxlength: 255
                            },
                    @elseif ($jenisSurat->kode === 'SP')
                        tujuan_instansi: {
                                required: true,
                                maxlength: 255
                            },
                            keperluan: {
                                required: true,
                                maxlength: 255
                            },
                    @endif
                    catatan: {
                        maxlength: 255
                    },
                    lampiran_ktp: {
                        required: {{ $isEdit ? 'false' : 'true' }}
                    },
                    lampiran_kk: {
                        required: {{ $isEdit ? 'false' : 'true' }}
                    }
                },
                messages: {
                    status_perkawinan: {
                        required: 'Status perkawinan wajib dipilih.'
                    },
                    nama_usaha: {
                        required: 'Nama usaha wajib diisi.'
                    },
                    lokasi_usaha: {
                        required: 'Lokasi usaha wajib diisi.'
                    },
                    tujuan_instansi: {
                        required: 'Tujuan instansi wajib diisi.'
                    },
                    keperluan: {
                        required: 'Keperluan wajib diisi.'
                    },
                    lampiran_ktp: {
                        required: 'File KTP wajib diunggah.'
                    },
                    lampiran_kk: {
                        required: 'File KK wajib diunggah.'
                    }
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
