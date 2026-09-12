@extends('system.layouts.layout')

@use('App\Enums\StatusSurat')

@push('styles')
    <link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Pengajuan Surat</h1>
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

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4 d-flex flex-wrap gap-2 align-items-center">
                                <button type="button" class="btn btn-sm btn-light filter-status active" data-status="">
                                    Semua <span class="badge bg-dark">{{ $pengajuan->count() }}</span>
                                </button>
                                @foreach (StatusSurat::cases() as $statusSurat)
                                    <button type="button" class="btn btn-sm btn-light filter-status"
                                        data-status="{{ $statusSurat->value }}"
                                        @if ($statusSurat->keterangan()) data-bs-toggle="tooltip" title="{{ $statusSurat->keterangan() }}" @endif>
                                        {{ $statusSurat->value }}
                                        <span class="badge {{ $statusSurat->badgeClass() }}">{{ $statusCounts->get($statusSurat->value, 0) }}</span>
                                    </button>
                                @endforeach

                                <select id="filter-jenis" class="form-select w-auto ms-auto">
                                    <option value="">Semua Jenis Surat</option>
                                    @foreach ($jenisSurat as $jenis)
                                        <option value="{{ $jenis->label }}">{{ $jenis->label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <table id="pengajuan-table" class="table w-100">
                                <thead>
                                    <tr>
                                        <th>Pemohon</th>
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
                                            <td>
                                                <strong>{{ $item->penduduk?->nama ?? '-' }}</strong><br>
                                                <small class="text-muted">{{ $item->penduduk?->nik ?? '-' }}</small>
                                            </td>
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
                                                <a href="{{ route('system.pengajuan.show', $item) }}"
                                                    class="btn btn-sm btn-light">Tinjau</a>
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
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // datatable client-side: search, sort, pagination semua di-handle browser
            var table = $('#pengajuan-table').DataTable({
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                order: [[2, 'desc']],
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
                table.column(4).search(status).draw();
            });

            $('#filter-jenis').on('change', function () {
                var jenis = $(this).val();
                table.column(1).search(jenis).draw();
            });
        });
    </script>
@endpush
