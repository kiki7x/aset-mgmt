@extends('layouts.backsite', [
    'title' => 'Peminjaman Aset | SAPA PPL',
    'welcome' => 'Peminjaman Aset',
    'breadcrumb' => '
        <li class="breadcrumb-item active">Peminjaman Aset</li>',
])

@push('script-head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- DateTimePicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex bd-highlight">
            <h3 class="card-title font-weight-bold mr-auto p-2 bd-highlight">
                <i class="fa-solid fa-handshake"></i> Peminjaman Aset
            </h3>
            <div class="p-2 bd-highlight">
                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#createRuanganModal">
                    <i class="fas fa-door-open"></i> Pinjam Ruangan
                </button>
                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#createBarangModal">
                    <i class="fas fa-box"></i> Pinjam Barang
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-2 mb-3 align-items-end">
                <div class="col-12 col-md-3">
                    <label for="filterType" class="form-label mb-1">Filter Jenis</label>
                    <select id="filterType" class="form-control">
                        <option value="">Semua Jenis</option>
                        <option value="ruangan">Ruangan</option>
                        <option value="barang">Barang</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table id="tablePeminjaman" class="table table-bordered table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Barang/Ruangan</th>
                            <th>Peminjam</th>
                            <th>Waktu</th>
                            <th>Tujuan</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create Peminjaman Ruangan -->
    <div class="modal fade" id="createRuanganModal" data-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Peminjaman Ruangan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formCreateRuangan" autocomplete="off">
                    @csrf
                    <input type="hidden" name="type" value="ruangan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Ruangan <span class="text-danger">*</span></label>
                                <select name="location_id" class="form-control select2" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach ($locations as $loc)
                                        <option value="{{ $loc->id }}">{{ $loc->building?->name ?? '-' }} - Lt {{ $loc->floor }} - {{ $loc->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger small" id="error-ruangan-location_id"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nama Peminjam <span class="text-danger">*</span></label>
                                <input type="text" name="borrower_name" class="form-control" required>
                                <span class="text-danger small" id="error-ruangan-borrower_name"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pilih dari User Sistem</label>
                                <select name="user_id" class="form-control select2">
                                    <option value="">-- Opsional --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" data-name="{{ $user->fullname }}">{{ $user->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>NIP/NIK</label>
                                <input type="text" name="borrower_nip" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Unit/Instansi</label>
                                <input type="text" name="borrower_unit" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal & Waktu Mulai <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="borrow_start" class="form-control datetimepicker" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                </div>
                                <span class="text-danger small" id="error-ruangan-borrow_start"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal & Waktu Akhir <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="borrow_end" class="form-control datetimepicker" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                </div>
                                <span class="text-danger small" id="error-ruangan-borrow_end"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Tujuan Peminjaman <span class="text-danger">*</span></label>
                                <textarea name="purpose" class="form-control" rows="2" required></textarea>
                                <span class="text-danger small" id="error-ruangan-purpose"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Catatan</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Create Peminjaman Barang -->
    <div class="modal fade" id="createBarangModal" data-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Peminjaman Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formCreateBarang" autocomplete="off">
                    @csrf
                    <input type="hidden" name="type" value="barang">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Barang <span class="text-danger">*</span></label>
                                <select name="asset_id" class="form-control select2" required>
                                    <option value="">-- Pilih Barang --</option>
                                </select>
                                <span class="text-danger small" id="error-barang-asset_id"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nama Peminjam <span class="text-danger">*</span></label>
                                <input type="text" name="borrower_name" class="form-control" required>
                                <span class="text-danger small" id="error-barang-borrower_name"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pilih dari User Sistem</label>
                                <select name="user_id" class="form-control select2">
                                    <option value="">-- Opsional --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" data-name="{{ $user->fullname }}">{{ $user->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>NIP/NIK</label>
                                <input type="text" name="borrower_nip" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Unit/Instansi</label>
                                <input type="text" name="borrower_unit" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal & Waktu Mulai <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="borrow_start" class="form-control datetimepicker" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                </div>
                                <span class="text-danger small" id="error-barang-borrow_start"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal & Waktu Akhir <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="borrow_end" class="form-control datetimepicker" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                </div>
                                <span class="text-danger small" id="error-barang-borrow_end"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Tujuan Peminjaman <span class="text-danger">*</span></label>
                                <textarea name="purpose" class="form-control" rows="2" required></textarea>
                                <span class="text-danger small" id="error-barang-purpose"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Catatan</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
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

    <!-- Modal Detail Peminjaman -->
    <div class="modal fade" id="showBorrowingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Peminjaman</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="showBorrowingBody">
                    <div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pengembalian -->
    <div class="modal fade" id="returnModal" data-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Pengembalian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formReturn" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p>Peminjam: <strong id="returnBorrowerName"></strong></p>
                        <div class="form-group">
                            <label>Foto Pengembalian <span class="text-danger">*</span></label>
                            <input type="file" name="return_photo" class="form-control" accept="image/*" required>
                            <span class="text-danger small" id="error-return-return_photo"></span>
                            <small class="text-muted">Format: JPG, PNG. Maks 5MB.</small>
                        </div>
                        <div id="returnPhotoPreview" class="mt-2" style="display:none;">
                            <img id="returnPreviewImg" class="img-fluid" style="max-height:200px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Proses Pengembalian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-foot')
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Moment.js (already loaded globally) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
            });

            // Initialize DateTimePicker
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD HH:mm',
                sideBySide: true,
                icons: {
                    time: 'fas fa-clock',
                    date: 'fas fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'fas fa-crosshairs',
                    clear: 'fas fa-trash',
                    close: 'fas fa-times'
                }
            });

            // Load available assets for barang modal
            loadAvailableAssets();

            // Auto-fill borrower name from user select
            $('#createRuanganModal select[name="user_id"], #createBarangModal select[name="user_id"]').on('change', function() {
                var selected = $(this).find(':selected');
                var name = selected.data('name');
                var form = $(this).closest('form');
                if (name) {
                    form.find('input[name="borrower_name"]').val(name);
                }
            });

            // DataTable
            initTablePeminjaman();

            // Filter type
            $('#filterType').on('change', function() {
                $('#tablePeminjaman').DataTable().ajax.reload();
            });
        });

        function loadAvailableAssets() {
            $.get('{{ route("admin.peminjaman.available.assets") }}', function(data) {
                var $select = $('#createBarangModal select[name="asset_id"]');
                $select.empty().append('<option value="">-- Pilih Barang --</option>');
                $.each(data, function(i, asset) {
                    var label = asset.tag + ' - ' + asset.name;
                    if (asset.classification) label += ' (' + asset.classification.name + ')';
                    $select.append('<option value="' + asset.id + '">' + label + '</option>');
                });
                $select.select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    dropdownParent: $('#createBarangModal'),
                });
            });
        }

        function initTablePeminjaman() {
            $('#tablePeminjaman').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('admin.peminjaman.data') }}",
                    data: function(d) {
                        d.type = $('#filterType').val();
                    }
                },
                language: {
                    emptyTable: 'Tidak ada data peminjaman.',
                    processing: 'Memuat...',
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ baris',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                    infoEmpty: 'Menampilkan 0 sampai 0 dari 0 entri',
                    paginate: {
                        previous: 'Sebelumnya',
                        next: 'Berikutnya'
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'type', name: 'type', render: function(data) {
                        return data === 'ruangan' ? '<span class="badge badge-info">Ruangan</span>' : '<span class="badge badge-primary">Barang</span>';
                    }},
                    { data: 'item_name', name: 'item_name' },
                    { data: 'borrower', name: 'borrower_name' },
                    { data: 'dates', name: 'borrow_start' },
                    { data: 'purpose', name: 'purpose' },
                    { data: 'status_badge', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[0, 'desc']],
            });
        }

        // Form Submit: Ruangan
        $('#formCreateRuangan').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.peminjaman.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#createRuanganModal').modal('hide');
                    form[0].reset();
                    form.find('.select2').val(null).trigger('change');
                    clearErrors('ruangan-');
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message });
                    $('#tablePeminjaman').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    clearErrors('ruangan-');
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#error-ruangan-' + key).text(value[0]);
                        });
                    }
                }
            });
        });

        // Form Submit: Barang
        $('#formCreateBarang').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.peminjaman.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#createBarangModal').modal('hide');
                    form[0].reset();
                    form.find('.select2').val(null).trigger('change');
                    clearErrors('barang-');
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message });
                    $('#tablePeminjaman').DataTable().ajax.reload();
                    loadAvailableAssets();
                },
                error: function(xhr) {
                    clearErrors('barang-');
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#error-barang-' + key).text(value[0]);
                        });
                    }
                }
            });
        });

        function clearErrors(prefix) {
            $('.text-danger.small').filter(function() {
                return $(this).attr('id') && $(this).attr('id').startsWith('error-' + prefix);
            }).text('');
        }

        // Show Detail Modal
        $('#tablePeminjaman').on('click', '.btn-show-borrowing', function() {
            var id = $(this).data('id');
            $('#showBorrowingBody').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat...</div>');
            $('#showBorrowingModal').modal('show');

            $.get('{{ url("admin/peminjaman") }}/' + id, function(data) {
                var html = '<table class="table table-bordered">';
                html += '<tr><th width="30%">Jenis</th><td>' + (data.type === 'ruangan' ? 'Ruangan' : 'Barang') + '</td></tr>';

                if (data.type === 'ruangan' && data.location) {
                    html += '<tr><th>Ruangan</th><td>' + (data.location.name || '-') + '<br><small class="text-muted">' + (data.location.building ? data.location.building.name : '') + ' Lt ' + (data.location.floor || '') + '</small></td></tr>';
                }
                if (data.type === 'barang' && data.asset) {
                    html += '<tr><th>Barang</th><td>' + (data.asset.name || '-') + '<br><small class="text-muted">' + (data.asset.tag || '') + '</small></td></tr>';
                }

                html += '<tr><th>Peminjam</th><td>' + (data.borrower_name || '-');
                if (data.user) html += '<br><small class="text-muted">' + data.user.email + '</small>';
                if (data.borrower_nip) html += '<br><small class="text-muted">NIP: ' + data.borrower_nip + '</small>';
                if (data.borrower_unit) html += '<br><small class="text-muted">Unit: ' + data.borrower_unit + '</small>';
                html += '</td></tr>';

                html += '<tr><th>Waktu Mulai</th><td>' + moment(data.borrow_start).format('DD MMMM YYYY HH:mm') + '</td></tr>';
                html += '<tr><th>Waktu Akhir</th><td>' + moment(data.borrow_end).format('DD MMMM YYYY HH:mm') + '</td></tr>';
                if (data.return_date) {
                    html += '<tr><th>Dikembalikan</th><td>' + moment(data.return_date).format('DD MMMM YYYY HH:mm') + '</td></tr>';
                }
                html += '<tr><th>Tujuan</th><td>' + (data.purpose || '-') + '</td></tr>';
                html += '<tr><th>Status</th><td>' + (data.status === 'dipinjam' ? '<span class="badge badge-warning">Dipinjam</span>' : '<span class="badge badge-success">Dikembalikan</span>') + '</td></tr>';
                if (data.notes) html += '<tr><th>Catatan</th><td>' + data.notes + '</td></tr>';
                if (data.borrower_photo) {
                    html += '<tr><th>Foto Peminjam</th><td><img src="{{ asset("storage") }}/' + data.borrower_photo + '" class="img-fluid" style="max-height:200px;"></td></tr>';
                }
                if (data.return_photo) {
                    html += '<tr><th>Foto Pengembalian</th><td><img src="{{ asset("storage") }}/' + data.return_photo + '" class="img-fluid" style="max-height:200px;"></td></tr>';
                }
                html += '</table>';

                $('#showBorrowingBody').html(html);
            });
        });

        // Return Modal
        var currentReturnId = null;
        $('#tablePeminjaman').on('click', '.btn-return-borrowing', function() {
            currentReturnId = $(this).data('id');
            $('#returnBorrowerName').text($(this).data('name'));
            $('#formReturn')[0].reset();
            $('#returnPhotoPreview').hide();
            $('#error-return-return_photo').text('');
            $('#returnModal').modal('show');
        });

        // Preview return photo
        $('input[name="return_photo"]').on('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#returnPreviewImg').attr('src', e.target.result);
                    $('#returnPhotoPreview').show();
                };
                reader.readAsDataURL(file);
            }
        });

        // Submit Return
        $('#formReturn').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '{{ url("admin/peminjaman") }}/' + currentReturnId + '/return',
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#returnModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message });
                    $('#tablePeminjaman').DataTable().ajax.reload();
                    loadAvailableAssets();
                },
                error: function(xhr) {
                    $('#error-return-return_photo').text('');
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#error-return-' + key).text(value[0]);
                        });
                    }
                }
            });
        });

        // Reset forms when modals close
        $('#createRuanganModal, #createBarangModal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $(this).find('.select2').val(null).trigger('change');
            $(this).find('.text-danger.small').text('');
        });
    </script>
@endpush
