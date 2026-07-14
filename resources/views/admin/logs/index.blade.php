@extends('layouts.backsite', [
    'title' => 'Logs | SAPA PPL',
    'welcome' => 'Logs',
    'breadcrumb' => '
    <li class="breadcrumb-item active">Logs</li>
    ',
])

@push('script-head')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-clock-rotate-left"></i> Activity Logs</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <select id="filter-module" class="form-control select2" style="width: 100%;">
                        <option value="">Semua Module</option>
                        <option value="aset">Aset</option>
                        <option value="tiket">Tiket</option>
                        <option value="pemeliharaan">Pemeliharaan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="filter-event" class="form-control select2" style="width: 100%;">
                        <option value="">Semua Event</option>
                        <option value="created">Created</option>
                        <option value="updated">Updated</option>
                        <option value="deleted">Deleted</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filter-user" class="form-control select2" style="width: 100%;">
                        <option value="">Semua User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" id="filter-date-from" class="form-control" placeholder="Dari Tanggal">
                </div>
                <div class="col-md-2">
                    <input type="date" id="filter-date-to" class="form-control" placeholder="Sampai Tanggal">
                </div>
            </div>
            <div class="table-responsive">
                <table id="logs-table" class="table table-bordered table-hover w-100">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Module</th>
                            <th>Event</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script-foot')
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap4.js"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih...',
                allowClear: true,
                width: '100%'
            });

            var table = $('#logs-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.logs.data") }}',
                    data: function (d) {
                        d.module = $('#filter-module').val();
                        d.event = $('#filter-event').val();
                        d.user_id = $('#filter-user').val();
                        d.date_from = $('#filter-date-from').val();
                        d.date_to = $('#filter-date-to').val();
                    }
                },
                columns: [
                    { data: 'waktu', name: 'created_at' },
                    { data: 'user_name', name: 'user_name', orderable: false },
                    { data: 'module', name: 'loggable_type', orderable: false },
                    { data: 'event_badge', name: 'event', orderable: false },
                    { data: 'description', name: 'description' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ],
                order: [[0, 'desc']],
                columnDefs: [
                    { targets: [0, 1, 2, 3, 5], className: 'text-center' }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/2.3.1/i18n/id.json'
                }
            });

            $('#filter-module, #filter-event, #filter-user, #filter-date-from, #filter-date-to').on('change', function () {
                table.ajax.reload();
            });
        });
    </script>
@endpush
