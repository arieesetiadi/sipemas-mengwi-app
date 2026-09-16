@extends('system.layouts.layout')

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card widget widget-stats h-100 mb-0">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-primary">
                                    <i class="material-icons-outlined">hourglass_top</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Butuh Tindakan</span>
                                    <span class="widget-stats-amount">{{ $ringkasan['butuhTindakan'] }}</span>
                                    <span class="widget-stats-info">Pengajuan belum diproses</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card widget widget-stats h-100 mb-0">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-success">
                                    <i class="material-icons-outlined">task_alt</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Selesai Bulan Ini</span>
                                    <span class="widget-stats-amount">{{ $ringkasan['selesaiBulanIni'] }}</span>
                                    <span class="widget-stats-info">Surat diterbitkan bulan ini</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card widget widget-stats h-100 mb-0">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-danger">
                                    <i class="material-icons-outlined">block</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Ditolak Bulan Ini</span>
                                    <span class="widget-stats-amount">{{ $ringkasan['ditolakBulanIni'] }}</span>
                                    <span class="widget-stats-info">Surat ditolak bulan ini</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card widget widget-stats h-100 mb-0">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-warning">
                                    <i class="material-icons-outlined">summarize</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Total Periode Ini</span>
                                    <span class="widget-stats-amount">{{ $ringkasan['totalPeriodeIni'] }}</span>
                                    <span class="widget-stats-info">Pengajuan masuk bulan ini</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Rekap Laporan per Jenis Surat</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('system.dashboard') }}" class="row g-2 align-items-center mb-4">
                                <div class="col-auto">
                                    <label for="filter-tahun" class="col-form-label">Tahun</label>
                                </div>
                                <div class="col-auto">
                                    <select name="tahun" id="filter-tahun" class="form-select" onchange="this.form.submit()">
                                        @foreach ($daftarTahun as $tahunOpsi)
                                            <option value="{{ $tahunOpsi }}" @selected($tahunOpsi === $tahun)>
                                                {{ $tahunOpsi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>

                            @if ($totalRekapTahunan === 0)
                                <div class="text-center py-4 text-muted">
                                    Belum ada surat selesai pada tahun ini.
                                </div>
                            @else
                                <div id="rekap-chart"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            var rekap = @json($rekapTahunan);

            var chartEl = document.querySelector('#rekap-chart');
            if (!chartEl) {
                return;
            }

            var options = {
                chart: {
                    type: 'bar',
                    height: 360,
                    stacked: false,
                    toolbar: { show: false }
                },
                series: rekap.map(function (baris) {
                    return {
                        name: baris.jenis,
                        data: baris.data
                    };
                }),
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
                },
                colors: ['#2269F5', '#00B37E', '#F5A623'],
                plotOptions: {
                    bar: {
                        columnWidth: '45%'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + ' surat';
                        }
                    }
                },
                yaxis: {
                    forceNiceScale: true
                }
            };

            new ApexCharts(chartEl, options).render();
        });
    </script>
@endpush
