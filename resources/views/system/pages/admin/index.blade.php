@extends('system.layouts.layout')

@push('styles')
    <link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description d-flex justify-content-between align-items-center">
                        <h1>Data Admin</h1>
                        <a href="{{ route('system.admin.create') }}" class="btn btn-primary">
                            <i class="material-icons">add</i> Tambah Admin
                        </a>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
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
                            <table id="admin-table" class="table w-100">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admin as $admin)
                                        <tr>
                                            <td>{{ $admin->nama }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->telepon ?? '-' }}</td>
                                            <td>{{ $admin->role?->label ?? '-' }}</td>
                                            <td>
                                                @if ($admin->is_active)
                                                    <span class="badge bg-success w-100 pt-2">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger w-100 pt-2">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td class="d-flex gap-2">
                                                <a href="{{ route('system.admin.edit', $admin) }}"
                                                    class="btn btn-sm btn-light">Edit</a>
                                                <button type="button" class="btn btn-sm w-100 {{ $admin->is_active ? 'btn-danger' : 'btn-success' }} btn-toggle-status"
                                                    data-admin-id="{{ $admin->id }}"
                                                    data-admin-nama="{{ $admin->nama }}"
                                                    data-status="{{ $admin->is_active ? 'nonaktif' : 'aktif' }}">
                                                    {{ $admin->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
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

    {{-- modal konfirmasi ganti status --}}
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="status-form" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Konfirmasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="status-modal-text"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="status-modal-submit">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#admin-table').DataTable({
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                order: [[0, 'asc']],
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

            $('.btn-toggle-status').on('click', function () {
                var adminId = $(this).data('admin-id');
                var adminNama = $(this).data('admin-nama');
                var status = $(this).data('status');
                var action = "{{ route('system.admin.status', ':id') }}".replace(':id', adminId);

                $('#status-form').attr('action', action);
                $('#status-modal-text').text('Yakin ingin meng' + status + 'kan admin "' + adminNama + '"?');

                new bootstrap.Modal(document.getElementById('statusModal')).show();
            });
        });
    </script>
@endpush
