@extends('layouts.backsite', [
    'title' => 'Data Lisensi | SAPA PPL',
    'welcome' => 'Data Lisensi',
    'breadcrumb' => '<li class="breadcrumb-item active">Data Lisensi</li>',
])

@push('script-head')
    <link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-file-code"></i> Daftar Lisensi</h3>
                    <div class="card-tools">
                        <button type="button" id="btnOpenCreateModal" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data" data-crud="true">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableLicenses" class="table table-bordered table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tag</th>
                                    <th>Kategori</th>
                                    <th>Nama</th>
                                    <th>Seats</th>
                                    <th>Status</th>
                                    <th>Timestamp</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create --}}
    <div id="createModal" title="Tambah Lisensi" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Lisensi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formCreateLicense">
                    @csrf
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="form-group col-4">
                                <label for="name">Nama Lisensi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lisensi" required>
                                <span id="error-name" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="tag">Tag <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tag" name="tag" placeholder="Otomatis terisi" required>
                                <span id="error-tag" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="serial">Serial <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="serial" name="serial" placeholder="Masukkan serial/password" required>
                                <span id="error-serial" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="status_id">Status <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="status_id" name="status_id" required>
                                    @foreach (\App\Models\LabelsModel::get() as $label)
                                        <option value="{{ $label->id }}">{{ $label->name }}</option>
                                    @endforeach
                                </select>
                                <span id="error-status_id" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="category_id">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="category_id" name="category_id" required>
                                    @foreach (\App\Models\LicensecategoriesModel::get() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span id="error-category_id" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="supplier_id" name="supplier_id" required>
                                    @foreach (\App\Models\SuppliersModel::get() as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                <span id="error-supplier_id" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="seats">Seats/Jumlah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="seats" name="seats" placeholder="Misal: 1, 10, unlimited" required>
                                <span id="error-seats" class="text-danger small"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script-foot')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        function initTableLicenses() {
            $('#tableLicenses').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthMenu: [
                    [10, 50, 100, -1],
                    [10, 50, 100, "Semua"]
                ],
                ajax: `{{ url('admin/license/get_license') }}`,
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
                    {
                        data: 'tag',
                        name: 'tag',
                        render: function(data, type, row) {
                            return '<a href="{{ url('admin/license') }}/' + row.id + '/overview">' + data + '</a>';
                        }
                    },
                    { data: 'category', name: 'category', searchable: false, orderable: false },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            return '<a href="{{ url('admin/license') }}/' + row.id + '/overview" class="font-weight-bold">' + data + '</a>';
                        }
                    },
                    { data: 'seats', name: 'seats' },
                    { data: 'status', name: 'status', searchable: false, orderable: false },
                    {
                        data: null,
                        name: 'timestamp',
                        render: function(data) {
                            return `<span class="text-muted small">Dibuat: ${moment(data.created_at).format('lll')} <br>
                            Diupdate: ${moment(data.updated_at).format('lll')}</span>`;
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'asc']],
            });
        }

        $(document).ready(function() {
            initTableLicenses();

            $('.select2').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#createModal')
            });

            $('#btnOpenCreateModal').on('click', function() {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: `{{ url('admin/license/next-tag') }}`,
                    type: 'GET',
                    success: function(response) {
                        $('#tag').val(response.tag);
                    }
                });
                $('#createModal').modal('show');
            });

            $('#formCreateLicense').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: `{{ url('admin/license/store') }}`,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#createModal').modal('hide');
                        $('#tableLicenses').DataTable().ajax.reload();
                        Swal.fire({ icon: 'success', title: 'Sukses', text: 'Lisensi berhasil ditambahkan.' });
                        $('#formCreateLicense')[0].reset();
                        $('#tag').val('');
                        $('.text-danger').text('');
                        $('.select2').val(null).trigger('change');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#error-' + key).text(value[0]);
                            });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan, silakan coba lagi.' });
                        }
                    }
                });
            });
        });

        $('#tableLicenses').on('click', '#delete-license', function() {
            const licenseId = $(this).data('id');
            const name = $(this).data('name');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus lisensi "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: `{{ url('admin/license/delete') }}/${licenseId}`,
                        type: 'DELETE',
                        success: function(response) {
                            $('#tableLicenses').DataTable().ajax.reload();
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Lisensi berhasil dihapus.' });
                        },
                        error: function(xhr) {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat menghapus lisensi.' });
                        }
                    });
                }
            });
        });
    </script>
@endpush
