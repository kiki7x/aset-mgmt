@extends('layouts.backsite', [
    'title' => 'Setting Klasifikasi | SAPA PPL',
    'welcome' => 'Setting Klasifikasi',
    'breadcrumb' => '
        <li class="breadcrumb-item"><a href="/admin/setting_attr">Setting Atribut</a></li>
        <li class="breadcrumb-item active">Klasifikasi</li>',
])

@push('script-head')
    {{-- DataTable Css --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid fa-database"></i> Klasifikasi</h3>
                        <div class="px-2 d-flex justify-content-end">
                            <a href="{{ route('admin.setting_attr') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                            <button type="button" id="btnOpenCreateModal" class="ml-0 btn btn-primary">
                                <i class="fas fa-square-plus"></i>
                                Tambah Klasifikasi
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="tableKlasifikasi" class="table table-bordered table-striped table-hover table-sm dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Klasifikasi</th>
                                        <th>Jumlah Aset</th>
                                        <th>Timestamp</th>
                                        {{-- <th>Updated At</th> --}}
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <div id="createModal" title="Tambah Klasifikasi" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Klasifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="" method="POST" id="formCreateKlasifikasi">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Klasifikasi</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama klasifikasi" required>
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
    <div id="editModal" title="Edit Klasifikasi" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Klasifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="" method="POST" id="formEditKlasifikasi">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">Nama Klasifikasi</label>
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
        // Kelola Table Klasifikasi
        function initTableKlasifikasi() {
            $('#tableKlasifikasi').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.setting_attr.klasifikasi.get_klasifikasi') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'hitungAset',
                        name: 'hitungAset'
                    },
                    {
                        data: null,
                        name: 'timestamp',
                        render: function(data) {
                            return `Dibuat: ${moment(data.created_at).format('lll')} <br>
                            Diupdate: ${moment(data.updated_at).format('lll')}`
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
                responsive: true,
            });
        }
        $(document).ready(function() {
            initTableKlasifikasi();

            // Handle Tambah Klasifikasi
            $('#btnOpenCreateModal').on('click', function() {
                $('#createModal').modal('show');
            });
            $('#formCreateKlasifikasi').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.setting_attr.klasifikasi.store') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#createModal').modal('hide');
                        $('#tableKlasifikasi').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        });
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON?.message === 'The name has already been taken.') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Gagal',
                                text: 'Klasifikasi dengan nama tersebut sudah ada.',
                            });
                        } else if (xhr.responseJSON?.errors) {
                            $each(xhr.responseJSON.errors, function(key, value) {
                                $(`#error-${key}`).text(value[0]);
                            })
                            Swal.fire({
                                icon: 'warning',
                                title: 'Gagal',
                                text: 'Nama klasifikasi sudah ada.',
                            });
                        }
                        return false;
                    }
                })
            });
        });

        // Handle Edit Klasifikasi
        $('#tableKlasifikasi').on('click', '#edit-klasifikasi', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#editModal .modal-title').text('Edit Klasifikasi (ID: ' + id + ' - ' + name + ')');
            $('#edit_name').attr('placeholder', name);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ url('/admin/setting_attr/klasifikasi/edit') }}/${id}`,
                type: 'GET',
                success: function(response) {
                    $('#edit_name').val(response.name);
                    $('#formEditKlasifikasi').data('id', response.id);
                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat mengambil data klasifikasi.',
                    });
                }
            });
        });

        // Handle Update Klasifikasi
        $('#formEditKlasifikasi').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `{{ url('/admin/setting_attr/klasifikasi/update') }}/${id}`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#tableKlasifikasi').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                    });
                },
                error: function(xhr) {
                    if (xhr.responseJSON?.message === 'The name has already been taken.') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Gagal',
                            text: 'Klasifikasi dengan nama tersebut sudah ada.',
                        });
                    } else if (xhr.responseJSON?.errors) {
                        $each(xhr.responseJSON.errors, function(key, value) {
                            $(`#error-edit_${key}`).text(value[0]);
                        })
                        Swal.fire({
                            icon: 'warning',
                            title: 'Gagal',
                            text: 'Nama klasifikasi sudah ada.',
                        });
                    }
                    return false;
                }
            })
        });
        // Handle Delete Klasifikasi
        $('#tableKlasifikasi').on('click', '#delete-klasifikasi', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus klasifikasi "${name}"?`,
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
                        url: `{{ url('/admin/setting_attr/klasifikasi/delete') }}/${id}`,
                        type: 'DELETE',
                        success: function(response) {
                            $('#tableKlasifikasi').DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus klasifikasi.',
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
