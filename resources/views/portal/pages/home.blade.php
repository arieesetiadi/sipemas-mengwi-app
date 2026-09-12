@extends('portal.layouts.layout')

@use('App\Enums\StatusSurat')

@push('styles')
    <link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet" />
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

            <div class="mb-5">
                <p class="text-muted mb-4">
                    Pilih jenis surat yang ingin diajukan:
                </p>

                <div class="row g-3">
                    @forelse ($jenisSurat as $jenisSurat)
                        <div class="col-xl-4">
                            <a href="{{ route('portal.pengajuan.create', $jenisSurat) }}"
                                class="card widget widget-stats widget-stats-btn text-decoration-none h-100">
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

            <div>
                <p class="text-muted mb-4">
                    Pantau surat yang telah diajukan.
                </p>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4 d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-sm btn-light filter-status active" data-status="">
                                        Semua <span class="badge bg-dark">{{ $pengajuan->count() }}</span>
                                    </button>
                                    @foreach (StatusSurat::cases() as $statusSurat)
                                        <button type="button" class="btn btn-sm btn-light filter-status" data-status="{{ $statusSurat->value }}"
                                            @if ($statusSurat->keterangan()) data-bs-toggle="tooltip" title="{{ $statusSurat->keterangan() }}" @endif>
                                            {{ $statusSurat->value }}
                                            <span class="badge {{ $statusSurat->badgeClass() }}">{{ $statusCounts->get($statusSurat->value, 0) }}</span>
                                        </button>
                                    @endforeach
                                </div>

                                <table id="pengajuan-table" class="table w-100">
                                    <thead>
                                        <tr>
                                            <th>Jenis Surat</th>
                                            <th>Tanggal Ajukan</th>
                                            <th>Nomor Surat</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengajuan as $item)
                                            <tr>
                                                <td>{{ $item->jenisSurat?->label ?? '-' }}</td>
                                                <td data-order="{{ $item->created_at?->format('Y-m-d H:i:s') }}">{{ $item->created_at?->format('d M Y') }}</td>
                                                <td>{{ $item->nomor_surat ?? '-' }}</td>
                                                <td>
                                                    <span class="badge {{ $item->status->badgeClass() }} w-100 pt-2"
                                                        @if ($item->status->keterangan()) data-bs-toggle="tooltip" title="{{ $item->status->keterangan() }}" @endif>
                                                        {{ $item->status->value }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-sm btn-light btn-lihat"
                                                            data-jenis="{{ $item->jenisSurat?->label ?? '-' }}"
                                                            data-kode="{{ $item->jenisSurat?->kode ?? '' }}"
                                                            data-tanggal="{{ $item->created_at?->format('d M Y') }}"
                                                            data-nomor="{{ $item->nomor_surat ?? '-' }}"
                                                            data-status="{{ $item->status->value }}"
                                                            data-status-perkawinan="{{ $item->status_perkawinan?->value ?? '-' }}"
                                                            data-nama-usaha="{{ $item->nama_usaha ?? '-' }}"
                                                            data-lokasi-usaha="{{ $item->lokasi_usaha ?? '-' }}"
                                                            data-tujuan="{{ $item->tujuan_instansi ?? '-' }}"
                                                            data-keperluan="{{ $item->keperluan ?? '-' }}"
                                                            data-catatan="{{ $item->catatan ?? '-' }}"
                                                            data-ditolak-pada="{{ $item->ditolak_pada?->format('d M Y H:i') ?? '-' }}"
                                                            data-ditolak-oleh="{{ $item->ditolakOleh?->nama ?? '-' }}"
                                                            data-catatan-penolakan="{{ $item->catatan_penolakan ?? '-' }}">
                                                            Lihat
                                                        </button>
                                                        @if ($item->status === StatusSurat::Selesai)
                                                            <a href="{{ route('portal.pengajuan.download', $item) }}"
                                                                class="btn btn-sm btn-success">Download</a>
                                                        @endif
                                                        @if ($item->status === StatusSurat::Ditolak)
                                                            <a href="{{ route('portal.pengajuan.edit', $item) }}"
                                                                class="btn btn-sm btn-warning">Ajukan Ulang</a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pengajuanModal" tabindex="-1" aria-labelledby="pengajuanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengajuanModalLabel">Detail Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="timeline-container" class="d-flex justify-content-between mb-4"></div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Jenis Surat</small>
                        <strong id="detail-jenis">-</strong>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <small class="text-muted d-block">Tanggal Ajukan</small>
                                <strong id="detail-tanggal">-</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <small class="text-muted d-block">Nomor Surat</small>
                                <strong id="detail-nomor">-</strong>
                            </div>
                        </div>
                    </div>
                    <div id="detail-khusus" class="mb-3"></div>

                    <div id="detail-catatan-wrapper" class="mb-3 d-none">
                        <small class="text-muted d-block">Catatan</small>
                        <p id="detail-catatan" class="mb-0">-</p>
                    </div>

                    <div id="detail-penolakan-wrapper" class="mb-3 d-none">
                        <hr>
                        <h6 class="fw-bold text-danger mb-2">Penolakan</h6>
                        <small class="text-muted d-block">Ditolak Pada</small>
                        <strong id="detail-ditolak-pada">-</strong>
                        <small class="text-muted d-block mt-2">Ditolak Oleh</small>
                        <strong id="detail-ditolak-oleh">-</strong>
                        <small class="text-muted d-block mt-2">Catatan Penolakan</small>
                        <p id="detail-catatan-penolakan" class="mb-0">-</p>
                    </div>
                </hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var table = $('#pengajuan-table').DataTable({
                lengthMenu: [5, 10, 25, 50],
                pageLength: 5,
                order: [[1, 'desc']],
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(difilter dari _MAX_ total data)',
                    zeroRecords: 'Tidak ada data yang cocok',
                    paginate: {
                        first: 'Awal',
                        last: 'Akhir',
                        next: 'Berikutnya',
                        previous: 'Sebelumnya'
                    }
                }
            });

            $('.filter-status').on('click', function () {
                $('.filter-status').removeClass('active');
                $(this).addClass('active');

                var status = $(this).data('status');
                table.column(3).search(status).draw();
            });

            var timelineSteps = ['Diajukan', 'Diverifikasi', 'Selesai'];

            function renderTimeline(status) {
                var html = '';

                if (status === 'Ditolak') {
                    html += timelineItem('Diajukan', 'done');
                    html += timelineItem('Ditolak', 'rejected');
                } else {
                    var current = timelineSteps.indexOf(status);

                    timelineSteps.forEach(function (step, index) {
                        var state = index < current ? 'done' : (index === current ? 'active' : 'pending');
                        html += timelineItem(step, state);
                    });
                }

                $('#timeline-container').html(html);
            }

            function timelineItem(label, state) {
                var color = 'bg-light';

                if (state === 'done' || state === 'active') {
                    color = 'bg-primary';
                }

                if (state === 'rejected') {
                    color = 'bg-danger';
                }

                var inner = '<span class="d-block" style="width:8px;height:8px;border-radius:50%;background:#fff;"></span>';

                if (state === 'done') {
                    inner = '<i class="material-icons">check</i>';
                }

                if (state === 'rejected') {
                    inner = '<i class="material-icons">close</i>';
                }

                var labelClass = state === 'rejected' ? 'text-danger fw-bold' : '';

                return '<div class="text-center flex-fill">' +
                    '<div class="d-flex justify-content-center align-items-center mx-auto mb-1 ' + color + '" style="width:32px;height:32px;border-radius:50%;color:#fff;">' + inner + '</div>' +
                    '<small class="' + labelClass + '">' + label + '</small>' +
                '</div>';
            }

            function fieldMarkup(label, value) {
                return '<div class="mb-3">' +
                    '<small class="text-muted d-block">' + label + '</small>' +
                    '<strong>' + value + '</strong>' +
                '</div>';
            }

            function renderDetailKhusus(kode, data) {
                var html = '';

                if (kode === 'SKD') {
                    html += fieldMarkup('Status Perkawinan', data.statusPerkawinan);
                } else if (kode === 'SKU') {
                    html += '<div class="row">' +
                        '<div class="col-6">' + fieldMarkup('Nama Usaha', data.namaUsaha) + '</div>' +
                        '<div class="col-6">' + fieldMarkup('Lokasi Usaha', data.lokasiUsaha) + '</div>' +
                    '</div>';
                } else if (kode === 'SP') {
                    html += fieldMarkup('Tujuan Instansi', data.tujuan);
                    html += fieldMarkup('Keperluan', data.keperluan);
                }

                $('#detail-khusus').html(html);
            }

            $('.btn-lihat').on('click', function () {
                var catatan = $(this).data('catatan');

                $('#detail-jenis').text($(this).data('jenis'));
                $('#detail-tanggal').text($(this).data('tanggal'));
                $('#detail-nomor').text($(this).data('nomor'));

                renderDetailKhusus($(this).data('kode'), {
                    statusPerkawinan: $(this).data('status-perkawinan'),
                    namaUsaha: $(this).data('nama-usaha'),
                    lokasiUsaha: $(this).data('lokasi-usaha'),
                    tujuan: $(this).data('tujuan'),
                    keperluan: $(this).data('keperluan')
                });

                if (catatan && catatan !== '-') {
                    $('#detail-catatan').text(catatan);
                    $('#detail-catatan-wrapper').removeClass('d-none');
                } else {
                    $('#detail-catatan-wrapper').addClass('d-none');
                }

                var status = $(this).data('status');

                if (status === 'Ditolak') {
                    $('#detail-ditolak-pada').text($(this).data('ditolak-pada'));
                    $('#detail-ditolak-oleh').text($(this).data('ditolak-oleh'));
                    $('#detail-catatan-penolakan').text($(this).data('catatan-penolakan'));
                    $('#detail-penolakan-wrapper').removeClass('d-none');
                } else {
                    $('#detail-penolakan-wrapper').addClass('d-none');
                }

                renderTimeline(status);

                new bootstrap.Modal(document.getElementById('pengajuanModal')).show();
            });
        });
    </script>
@endpush
