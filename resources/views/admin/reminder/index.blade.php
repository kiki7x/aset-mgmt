@extends('layouts.backsite', [
    'title' => 'Reminder | SAPA PPL',
    'welcome' => 'Reminder',
    'breadcrumb' => '
    <li class="breadcrumb-item active">Reminder</li>
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
            <h3 class="card-title font-weight-bold"><i class="fa-regular fa-bell"></i> Reminder Pemeliharaan</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <select id="filter-classification" class="form-control select2" style="width: 100%;">
                        <option value="">Semua Klasifikasi</option>
                        <option value="2">Aset TIK</option>
                        <option value="3">Aset Rumah Tangga</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="filter-status" class="form-control select2" style="width: 100%;">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="sent">Terkirim</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table id="reminder-table" class="table table-bordered table-hover w-100">
                    <thead>
                        <tr>
                            <th>Jadwal</th>
                            <th>Klasifikasi</th>
                            <th>Aset</th>
                            <th>Jatuh Tempo</th>
                            <th>Reminder</th>
                            <th>Status Kirim</th>
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

            var table = $('#reminder-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.reminder.data") }}',
                    data: function (d) {
                        d.classification = $('#filter-classification').val();
                        d.status = $('#filter-status').val();
                    }
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'classification', name: 'classification', orderable: false },
                    { data: 'asset_name', name: 'asset_name', orderable: false },
                    { data: 'jatuh_tempo', name: 'end' },
                    { data: 'reminder_hari', name: 'reminder', orderable: false },
                    { data: 'status_kirim', name: 'last_reminder_sent_at', orderable: false },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ],
                order: [[3, 'asc']],
                columnDefs: [
                    { targets: [1, 2, 4, 5, 6], className: 'text-center' }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/2.3.1/i18n/id.json'
                }
            });

            $('#filter-classification, #filter-status').on('change', function () {
                table.ajax.reload();
            });
        });
    </script>
@endpush
