@extends('layouts.backsite', [
    'title' => 'Monitoring | SAPA PPL',
    'welcome' => 'Monitoring',
    'breadcrumb' => '
    <li class="breadcrumb-item active">Monitoring</li>
    ',
])

@push('script-head')
    <style>
        .monitor-card { border-left: 5px solid #6c757d; }
        .monitor-card.up { border-left-color: #28a745; }
        .monitor-card.down { border-left-color: #dc3545; }
        .status-dot { height: 12px; width: 12px; border-radius: 50%; display: inline-block; }
        .status-dot.up { background-color: #28a745; }
        .status-dot.down { background-color: #dc3545; }
        .status-dot.unknown { background-color: #6c757d; }
    </style>
@endpush

@section('content')
    {{-- KARTU STATUS LIVE --}}
    <div class="row" id="status-cards">
        @forelse ($monitors as $monitor)
            <div class="col-md-4 col-sm-6">
                <div class="card monitor-card {{ $monitor->last_status }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1">
                                    <i class="fa-solid {{ $monitor->type === 'server' ? 'fa-server' : 'fa-globe' }} mr-1"></i>
                                    {{ $monitor->name }}
                                </h5>
                                <small class="text-muted">{{ $monitor->url }}</small>
                            </div>
                            <span class="status-dot {{ $monitor->last_status ?? 'unknown' }}"></span>
                        </div>
                        <hr class="my-2">
                        <div class="row text-center">
                            <div class="col-4">
                                <strong class="d-block">
                                    @if ($monitor->last_status === 'up')
                                        <span class="text-success">UP</span>
                                    @elseif ($monitor->last_status === 'down')
                                        <span class="text-danger">DOWN</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </strong>
                                <small class="text-muted">Status</small>
                            </div>
                            <div class="col-4">
                                <strong class="d-block">{{ $monitor->uptime_24h }}%</strong>
                                <small class="text-muted">Uptime 24j</small>
                            </div>
                            <div class="col-4">
                                <strong class="d-block">{{ $monitor->last_response_time ?? '-' }} ms</strong>
                                <small class="text-muted">Respon</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="callout callout-info">Belum ada monitor. Tambahkan monitor di bawah.</div>
            </div>
        @endforelse
    </div>

    {{-- GRAFIK ANALITIK --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-chart-line"></i> Grafik Riwayat</h3>
            <div class="d-flex" style="gap: 8px;">
                <select id="chart-monitor" class="form-control form-control-sm">
                    @foreach ($monitors as $monitor)
                        <option value="{{ $monitor->id }}">{{ $monitor->name }}</option>
                    @endforeach
                </select>
                <select id="chart-range" class="form-control form-control-sm">
                    <option value="24h">24 Jam</option>
                    <option value="7d">7 Hari</option>
                    <option value="30d">30 Hari</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-center">Uptime (%)</h6>
                    <div style="position: relative; height: 250px;">
                        <canvas id="uptimeChart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-center">Response Time (ms)</h6>
                    <div style="position: relative; height: 250px;">
                        <canvas id="responseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL CRUD MONITOR --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-list"></i> Daftar Monitor</h3>
            <button class="btn btn-primary btn-sm" id="btn-add"><i class="fa-solid fa-plus mr-1"></i> Tambah Monitor</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="monitor-table" class="table table-bordered table-hover w-100">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>URL</th>
                            <th>Interval</th>
                            <th>Status</th>
                            <th>Aktif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL ADD/EDIT --}}
    <div class="modal fade" id="monitor-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="monitor-form">
                    @csrf
                    <input type="hidden" id="monitor-id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Tambah Monitor</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="m-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Tipe</label>
                            <select class="form-control" id="m-type" name="type" required>
                                <option value="website">Website</option>
                                <option value="server">Server</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="url" class="form-control" id="m-url" name="url" placeholder="https://..." required>
                        </div>
                        <div class="form-group">
                            <label>Interval (menit)</label>
                            <input type="number" class="form-control" id="m-interval" name="interval" min="1" value="{{ config('monitoring.default_interval', 5) }}" required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="m-active" name="is_active" value="1" checked>
                                <label class="custom-control-label" for="m-active">Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-foot')
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

            var table = $('#monitor-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.monitoring.data") }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'type_label', name: 'type', className: 'text-center' },
                    { data: 'url', name: 'url' },
                    { data: 'interval_label', name: 'interval', className: 'text-center' },
                    { data: 'status_badge', name: 'last_status', className: 'text-center' },
                    { data: 'active_badge', name: 'is_active', className: 'text-center' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-center' }
                ],
                language: {
                    emptyTable: 'Tidak ada data.',
                    processing: 'Memuat...',
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ baris',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                    infoEmpty: 'Menampilkan 0 sampai 0 dari 0 entri',
                    zeroRecords: 'Tidak ada data yang cocok.',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' }
                }
            });

            // Tambah
            $('#btn-add').on('click', function () {
                $('#monitor-form')[0].reset();
                $('#monitor-id').val('');
                $('#modal-title').text('Tambah Monitor');
                $('#m-active').prop('checked', true);
                $('#monitor-modal').modal('show');
            });

            // Edit
            $('#monitor-table').on('click', '.btn-edit', function () {
                var id = $(this).data('id');
                $.get('{{ url("admin/monitoring") }}/' + id + '/edit', function (data) {
                    $('#monitor-id').val(data.id);
                    $('#m-name').val(data.name);
                    $('#m-type').val(data.type);
                    $('#m-url').val(data.url);
                    $('#m-interval').val(data.interval);
                    $('#m-active').prop('checked', data.is_active);
                    $('#modal-title').text('Edit Monitor');
                    $('#monitor-modal').modal('show');
                });
            });

            // Submit (store/update)
            $('#monitor-form').on('submit', function (e) {
                e.preventDefault();
                var id = $('#monitor-id').val();
                var url = id ? '{{ url("admin/monitoring") }}/' + id + '/update' : '{{ route("admin.monitoring.store") }}';
                var method = id ? 'PATCH' : 'POST';

                var payload = {
                    name: $('#m-name').val(),
                    type: $('#m-type').val(),
                    url: $('#m-url').val(),
                    interval: $('#m-interval').val(),
                    is_active: $('#m-active').is(':checked') ? 1 : 0
                };

                $.ajax({
                    url: url, method: method, data: payload,
                    success: function (res) {
                        $('#monitor-modal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1800, showConfirmButton: false });
                    },
                    error: function (xhr) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON?.message || 'Periksa input Anda.' });
                    }
                });
            });

            // Hapus
            $('#monitor-table').on('click', '.btn-delete', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus monitor?', icon: 'warning', showCancelButton: true,
                    confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal', confirmButtonColor: '#dc3545'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url("admin/monitoring") }}/' + id + '/destroy', method: 'DELETE',
                            success: function (res) {
                                table.ajax.reload();
                                Swal.fire({ icon: 'success', title: 'Terhapus', text: res.message, timer: 1800, showConfirmButton: false });
                            }
                        });
                    }
                });
            });

            // Cek Sekarang
            $('#monitor-table').on('click', '.btn-check-now', function () {
                var id = $(this).data('id');
                var btn = $(this);
                btn.html('<i class="fa-solid fa-spinner fa-spin"></i>').prop('disabled', true);
                $.ajax({
                    url: '{{ url("admin/monitoring") }}/' + id + '/check', method: 'POST',
                    success: function (res) {
                        table.ajax.reload();
                        Swal.fire({ icon: res.status === 'up' ? 'success' : 'error', title: res.status.toUpperCase(), text: res.message, timer: 2000, showConfirmButton: false });
                    },
                    complete: function () {
                        btn.html('<i class="fa-solid fa-bolt"></i>').prop('disabled', false);
                    }
                });
            });

            // GRAFIK
            var uptimeChart, responseChart;

            function loadChart() {
                var monitorId = $('#chart-monitor').val();
                var range = $('#chart-range').val();
                if (!monitorId) return;

                $.get('{{ url("admin/monitoring") }}/' + monitorId + '/chart', { range: range }, function (data) {
                    if (uptimeChart) uptimeChart.destroy();
                    if (responseChart) responseChart.destroy();

                    uptimeChart = new Chart(document.getElementById('uptimeChart'), {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{ label: 'Uptime %', data: data.uptime, borderColor: '#28a745', backgroundColor: 'rgba(40,167,69,0.1)', fill: true, tension: 0.3 }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, max: 100 } } }
                    });

                    responseChart = new Chart(document.getElementById('responseChart'), {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{ label: 'Response Time (ms)', data: data.response_time, borderColor: '#007bff', backgroundColor: 'rgba(0,123,255,0.1)', fill: true, tension: 0.3 }]
                        },
                        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
                    });
                });
            }

            $('#chart-monitor, #chart-range').on('change', loadChart);
            @if ($monitors->isNotEmpty())
                loadChart();
            @endif
        });
    </script>
@endpush
