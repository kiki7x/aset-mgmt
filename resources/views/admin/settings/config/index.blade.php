@extends('layouts.backsite', [
    'title' => 'Config | SAPA PPL',
    'welcome' => 'Konfigurasi',
    'breadcrumb' => '
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Config</li>
    ',
])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <form id="form-config">
                @csrf
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="configTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-fonnte-link" data-toggle="pill" href="#tab-fonnte"
                                    role="tab" aria-selected="true">
                                    <i class="fa-brands fa-whatsapp"></i> Fonnte
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-smtp-link" data-toggle="pill" href="#tab-smtp" role="tab"
                                    aria-selected="false">
                                    <i class="fa-solid fa-envelope"></i> SMTP Email
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-cron-link" data-toggle="pill" href="#tab-cron" role="tab"
                                    aria-selected="false">
                                    <i class="fa-solid fa-clock"></i> Cron Jobs
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-monitoring-link" data-toggle="pill" href="#tab-monitoring"
                                    role="tab" aria-selected="false">
                                    <i class="fa-solid fa-heart-pulse"></i> Monitoring
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="configTabContent">
                            {{-- FONNTE --}}
                            <div class="tab-pane fade show active" id="tab-fonnte" role="tabpanel">
                                <div class="form-group">
                                    <label for="fonnte_token">Token</label>
                                    <input type="text" class="form-control" id="fonnte_token" name="fonnte_token"
                                        value="{{ $fonnteToken }}" placeholder="Masukkan token Fonnte">
                                </div>
                                <div class="form-group">
                                    <label for="fonnte_sender">Sender</label>
                                    <input type="text" class="form-control" id="fonnte_sender" name="fonnte_sender"
                                        value="{{ $fonnteSender }}" placeholder="Nomor pengirim">
                                </div>
                                <div class="form-group mb-0">
                                    <label for="fonnte_group_id">Group ID</label>
                                    <input type="text" class="form-control" id="fonnte_group_id" name="fonnte_group_id"
                                        value="{{ $fonnteGroupId }}" placeholder="ID grup WhatsApp">
                                </div>
                            </div>

                            {{-- SMTP EMAIL --}}
                            <div class="tab-pane fade" id="tab-smtp" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8 form-group">
                                        <label for="mail_host">Host</label>
                                        <input type="text" class="form-control" id="mail_host" name="mail_host"
                                            value="{{ $mailHost }}" placeholder="smtp.gmail.com">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="mail_port">Port</label>
                                        <input type="number" class="form-control" id="mail_port" name="mail_port"
                                            value="{{ $mailPort }}" placeholder="587">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mail_username">Username</label>
                                    <input type="text" class="form-control" id="mail_username" name="mail_username"
                                        value="{{ $mailUsername }}" placeholder="Username SMTP">
                                </div>
                                <div class="form-group">
                                    <label for="mail_password">Password</label>
                                    <input type="password" class="form-control" id="mail_password" name="mail_password"
                                        value="{{ $mailPassword }}" placeholder="Password SMTP">
                                </div>
                                <div class="form-group">
                                    <label for="mail_encryption">Encryption</label>
                                    <select class="form-control" id="mail_encryption" name="mail_encryption">
                                        <option value="tls" {{ $mailEncryption === 'tls' ? 'selected' : '' }}>TLS</option>
                                        <option value="ssl" {{ $mailEncryption === 'ssl' ? 'selected' : '' }}>SSL</option>
                                        <option value="null" {{ $mailEncryption === 'null' ? 'selected' : '' }}>None</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-0">
                                        <label for="mail_from_address">From Address</label>
                                        <input type="email" class="form-control" id="mail_from_address"
                                            name="mail_from_address" value="{{ $mailFromAddress }}"
                                            placeholder="noreply@ppl.ac.id">
                                    </div>
                                    <div class="col-md-6 form-group mb-0">
                                        <label for="mail_from_name">From Name</label>
                                        <input type="text" class="form-control" id="mail_from_name" name="mail_from_name"
                                            value="{{ $mailFromName }}" placeholder="SAPA PPL">
                                    </div>
                                </div>
                            </div>

                            {{-- CRON JOBS --}}
                            <div class="tab-pane fade" id="tab-cron" role="tabpanel">
                                <div class="callout callout-info">
                                    <p class="mb-0"><i class="fa-solid fa-circle-info mr-1"></i>
                                        Halaman ini adalah <strong>referensi untuk admin hosting</strong>. Pasang cron entry
                                        di bawah pada server agar penjadwalan otomatis (reminder, dll) berjalan.</p>
                                </div>

                                <div class="form-group">
                                    <label>Cron Entry Utama (Laravel Scheduler)</label>
                                    <div class="input-group">
                                        <pre class="form-control bg-dark text-light mb-0" id="cron-entry" style="white-space: pre-wrap; word-break: break-all; padding: 10px;">* * * * * cd {{ base_path() }} && php artisan schedule:run >> /dev/null 2>&1</pre>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary btn-copy" data-target="cron-entry">
                                                <i class="fa-solid fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-muted">Cron ini jalan tiap menit; Laravel yang menentukan command mana dijalankan sesuai jadwalnya.</small>
                                </div>

                                <div class="form-group">
                                    <label>Path Project</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="project-path" value="{{ base_path() }}" readonly>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary btn-copy" data-target="project-path">
                                                <i class="fa-solid fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Daftar Scheduled Command</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Command</th>
                                                    <th>Jadwal</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><code>app:whatsapp-reminder-command</code></td>
                                                    <td>Harian, 07:30</td>
                                                    <td>Reminder WhatsApp pemeliharaan aset</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label>Petunjuk Singkat (cPanel)</label>
                                    <ol class="mb-0 pl-3">
                                        <li>Login cPanel, buka menu <strong>Cron Jobs</strong>.</li>
                                        <li>Pada <em>Common Settings</em>, pilih <strong>Once Per Minute (* * * * *)</strong>.</li>
                                        <li>Salin dan tempel <em>Cron Entry Utama</em> di atas pada kolom <strong>Command</strong>.</li>
                                        <li>Klik <strong>Add New Cron Job</strong>.</li>
                                    </ol>
                                </div>
                            </div>

                            {{-- MONITORING --}}
                            <div class="tab-pane fade" id="tab-monitoring" role="tabpanel">
                                <div class="callout callout-info">
                                    <p class="mb-0"><i class="fa-solid fa-circle-info mr-1"></i>
                                        Pengaturan default untuk fitur Monitoring heartbeat services.</p>
                                </div>
                                <div class="form-group">
                                    <label for="monitor_default_interval">Interval Default (menit)</label>
                                    <input type="number" class="form-control" id="monitor_default_interval"
                                        name="monitor_default_interval" min="1" value="{{ $monitorDefaultInterval }}"
                                        placeholder="5">
                                    <small class="text-muted">Interval pengecekan default saat menambah monitor baru.</small>
                                </div>
                                <div class="form-group mb-0">
                                    <label for="monitor_retention_days">Retensi Log (hari)</label>
                                    <input type="number" class="form-control" id="monitor_retention_days"
                                        name="monitor_retention_days" min="1" value="{{ $monitorRetentionDays }}"
                                        placeholder="730">
                                    <small class="text-muted">Data heartbeat lebih tua dari ini akan dihapus otomatis. Default 730 hari (2 tahun).</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk mr-1"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script-foot')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#form-config').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route("admin.settings.config.update") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                        });
                    }
                });
            });

            // Copy-to-clipboard untuk tab Cron Jobs
            $('.btn-copy').on('click', function () {
                var targetId = $(this).data('target');
                var text = $('#' + targetId).text() || $('#' + targetId).val();
                navigator.clipboard.writeText(text.trim()).then(function () {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Disalin ke clipboard',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            });
        });
    </script>
@endpush
