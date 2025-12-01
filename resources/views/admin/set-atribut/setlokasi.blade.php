@extends('layouts.backsite', [
    'title' => 'Setting Lokasi | SAPA PPL',
    'welcome' => 'Setting Lokasi',
    'breadcrumb' => '
        <li class="breadcrumb-item"><a href="/admin/setting_attr">Setting Atribut</a></li>
        <li class="breadcrumb-item active">Lokasi</li>',
])

@push('script-head')
    {{-- DataTable Css --}}
    <link rel="stylesheet" href="{{ asset("https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css") }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-database"></i> Daftar Lokasi</h3>
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
                        <table id="tableLokasi" class="table table-bordered table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Gedung</th>
                                    <th>Nama Ruangan</th>
                                    <th>Timestamp</th>
                                    <th>Aksi</th>
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
    <div id="createModal" title="Tambah Gedung" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Gedung</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="" method="POST" id="formCreateGedung">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Gedung</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama Gedung" required>
                        </div>
                        <span id="error-name" class="text-danger small"></span>
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
    <div id="editModal" title="Edit Lokasi" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Lokasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="" method="POST" id="formEditLokasi">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">Nama Lokasi</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <span id="error-edit_name" class="text-danger small"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-foot')
    <script>
        // Table Model
        function initTableModel() {
            $('#tableLokasi').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: `{{ url('admin/setting_attr/lokasi/get_lokasi') }}`,
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
                        data: 'ruangan',
                        name: 'ruangan',
                        render: function(data, type, row) {
                            // return data ? data : '<span class="text-muted">Tidak ada ruangan</span>';
                            return data ? `<span class="badge text-primary">${data}</span>` : `<span class="text-muted">Tidak ada ruangan</span>`;

                        }
                    },
                    {
                        data: null,
                        name: 'timestamp',
                        render: function(data) {
                            return `<span class="text-muted small">Dibuat: ${moment(data.created_at).format('lll')} <br>
                                Diupdate: ${moment(data.updated_at).format('lll')}</span>`;
                        },
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
            initTableModel();

            // Handle Tambah Model
            $('#btnOpenCreateModal').on('click', function() {
                $('#createModal').modal('show');
            });
            $('#formCreateModel').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ url('admin/setting_attr/model/store') }}`,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#createModal').modal('hide');
                        $('#tableModel').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Model berhasil ditambahkan.',
                        });
                        $('#formCreateModel')[0].reset();
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

        // Handle Edit Mpdel
        $('#tableModel').on('click', '#edit-model', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#edit_name').attr('placeholder', name);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ url('admin/setting_attr/model/edit') }}/${id}`,
                type: 'GET',
                success: function(response) {
                    $('#edit_name').val(response.name);
                    $('#formEditModel').data('id', response.id);
                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    toastr.error('Terjadi kesalahan, silakan coba lagi.');
                }
            });
        });

        // Handle Update Model
        $('#formEditModel').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ url('admin/setting_attr/model/update') }}/${id}`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#tableModel').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Model berhasil diperbarui.',
                    });
                    $('#formEditModel')[0].reset();
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
        $('#tableModel').on('click', '#delete-model', function() {
            const merkId = $(this).data('id');
            const name = $(this).data('name');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus model "${name}"?`,
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
                        url: `{{ url('admin/setting_attr/model/delete') }}/${merkId}`,
                        type: 'DELETE',
                        success: function(response) {
                            $('#tableModel').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Model berhasil dihapus.',
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus model.',
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
