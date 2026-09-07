@extends('portal.layouts.layout')

@push('styles')
    <style>
        .widget-stats.widget-stats-btn .widget-stats-container .widget-stats-content .widget-stats-amount {
            font-size: 22px;
            letter-spacing: unset;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex align-items-center">
                        <div class="page-description-content flex-grow-1">
                            <h1>Beranda</h1>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-muted mb-4">Pilih jenis surat yang ingin diajukan:</p>

            <div class="row g-3">
                @forelse ($jenisSurat as $jenisSurat)
                    <div class="col-xl-4">
                        <a href="#" class="card widget widget-stats widget-stats-btn text-decoration-none h-100">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-amount mb-2">Ajukan {{ $jenisSurat->label }}</span>
                                        <span class="widget-stats-info">{{ $jenisSurat->kode }}</span>
                                    </div>
                                    <div class="widget-stats-indicator widget-stats-indicator-positive align-self-start">
                                        <i class="material-icons">arrow_forward</i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">Belum ada jenis surat yang tersedia.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
