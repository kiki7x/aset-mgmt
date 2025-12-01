@extends('layouts.backsite', [
    'title' => 'Setting Supplier | SAPA PPL',
    'welcome' => 'Setting Supplier',
    'breadcrumb' => '
        <li class="breadcrumb-item"><a href="/admin/setting_attr">Setting Atribut</a></li>
        <li class="breadcrumb-item active">Supplier</li>',
])

@push('script-head')
    {{-- DataTable Css --}}
    <link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-database"></i> Daftar Supplier</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.setting_attr') }}" class="btn btn-secondary mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Kembali ke Setting Atribut">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="button" id="btnOpenCreateModal" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableSupplier" class="table table-bordered table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Supplier</th>
                                    <th>Alamat</th>
                                    <th>Nama Kontak</th>
                                    <th>No Telepon</th>
                                    <th>Email</th>
                                    <th>Notes</th>
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
    <div id="createModal" title="Tambah Supplier" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="" method="POST" id="formCreateSupplier">
                    @csrf
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="form-group col-4">
                                <label for="name">Nama Supplier <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama Supplier" required>
                                <span id="error-name" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-8">
                                <label for="address">Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Masukkan Alamat Supplier" required>
                                <span id="error-address" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="contactname">Nama Kontak <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="contactname" name="contactname" placeholder="Masukkan Alamat Supplier" required>
                                <span id="error-contactname" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="phone">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan Alamat Supplier" required>
                                <span id="error-phone" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan Alamat Supplier" required>
                                <span id="error-email" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-12">
                                <label for="notes">Notes</label>
                                <input type="text" name="notes" class="form-control" id="notes" placeholder="Notes">
                                <span id="error-notes" class="text-danger"></span>
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

    {{-- Modal Edit --}}
    <div id="editModal" title="Edit Supplier" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="" method="POST" id="formEditSupplier">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="form-group col-4">
                                <label for="edit_name">Nama Supplier <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <span id="error-edit_name" class="text-danger small"></span>
                            <div class="form-group col-8">
                                <label for="edit_address">Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_address" name="address" placeholder="Masukkan Alamat Supplier" required>
                                <span id="error-edit_address" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="edit_contactname">Nama Kontak <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_contactname" name="contactname" placeholder="Masukkan Alamat Supplier" required>
                                <span id="error-edit_contactname" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="edit_phone">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_phone" name="phone" placeholder="Masukkan Alamat Supplier" required>
                                <span id="error-edit_phone" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="edit_email">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_email" name="email" placeholder="Masukkan Alamat Supplier" required>
                                <span id="error-edit_email" class="text-danger small"></span>
                            </div>
                            <div class="form-group col-12">
                                <label for="edit_notes">Notes</label>
                                <input type="text" name="notes" class="form-control" id="edit_notes" placeholder="Notes">
                                <span id="error-edit_notes" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-foot')
    <script>
        // Table Supplier
        function initTableSupplier() {
            $('#tableSupplier').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: `{{ url('admin/setting_attr/supplier/get_supplier') }}`,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'address',
                        name: 'address',
                    },
                    {
                        data: 'contactname',
                        name: 'contactname',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'notes',
                        name: 'notes',
                    },
                    {
                        data: null,
                        name: 'timestamp',
                        render: function(data) {
                            return `<span class="text-muted small">Dibuat: ${moment(data.created_at).format('lll')} <br>
                            Diupdate: ${moment(data.updated_at).format('lll')}</span>`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'asc']
                ],
            });
        }

        $(document).ready(function() {
            initTableSupplier();

            // Handle Tambah Supplier
            $('#btnOpenCreateModal').on('click', function() {
                $('#createModal').modal('show');
            });
            $('#formCreateSupplier').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ url('admin/setting_attr/supplier/store') }}`,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#createModal').modal('hide');
                        $('#tableSupplier').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Supplier berhasil ditambahkan.',
                        });
                        $('#formCreateSupplier')[0].reset();
                        $('#error-name').text('');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $('#error-name').text(errors.name ? errors.name[0] : '');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan, silakan coba lagi.',
                            });
                            $('#error-name').text('');
                        }
                    }
                });
            });
        });

        // Handle Edit Supplier
        $('#tableSupplier').on('click', '#edit-supplier', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_name').attr('placeholder', name);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ url('admin/setting_attr/supplier/edit') }}/${id}`,
                type: 'GET',
                success: function(response) {
                    $('#edit_name').val(response.name);
                    $('#edit_address').val(response.address);
                    $('#edit_contactname').val(response.contactname);
                    $('#edit_phone').val(response.phone);
                    $('#edit_email').val(response.email);
                    $('#edit_notes').val(response.notes);
                    $('#formEditSupplier').data('id', response.id);
                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    toastr.error('Terjadi kesalahan, silakan coba lagi.');
                }
            });
        });

        // Handle Update Supplier
        $('#formEditSupplier').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ url('admin/setting_attr/supplier/update') }}/${id}`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#tableSupplier').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Supplier berhasil diperbarui.',
                    });
                    $('#formEditSupplier')[0].reset();
                    $('#error-edit_name').text('');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#error-edit_name').text(errors.name ? errors.name[0] : '');
                    } else {
                        toastr.error('Terjadi kesalahan, silakan coba lagi.');
                    }
                }
            });
        });

        // Handle Delete Merk
        $('#tableSupplier').on('click', '#delete-supplier', function() {
            const merkId = $(this).data('id');
            const name = $(this).data('name');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus supplier "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `{{ url('admin/setting_attr/supplier/delete') }}/${merkId}`,
                        type: 'DELETE',
                        success: function(response) {
                            $('#tableSupplier').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Supplier berhasil dihapus.',
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus supplier.',
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
