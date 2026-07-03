@extends('layouts.backsite', [
    'title' => 'Setting Kategori Lisensi | SAPA PPL',
    'welcome' => 'Setting Kategori Lisensi',
    'breadcrumb' => '
        <li class="breadcrumb-item"><a href="/admin/setting_attr">Setting Atribut</a></li>
        <li class="breadcrumb-item active">Kategori Lisensi</li>',
])

@push('script-head')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa-solid fa-database"></i> Kategori Lisensi</h3>
                        <div class="px-2 d-flex justify-content-end">
                            <a href="{{ route('admin.setting_attr') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                            <button type="button" id="btnOpenCreateModal" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data" data-crud="true">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableKategorilisensi" class="table table-bordered table-striped table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Kategori</th>
                                        <th>Tanggal</th>
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
    </div>

    <div id="createModal" title="Tambah Kategori Lisensi" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori Lisensi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formCreateKategorilisensi">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Kategori</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama kategori" required>
                        </div>
                        <span id="error-name" class="text-danger small"></span>
                        <div>
                            <label for="color">Warna</label>
                            <input type="color" class="form-control" id="color" name="color" default="#000000">
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

    <div id="editModal" title="Edit Kategori Lisensi" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori Lisensi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formEditKategorilisensi">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">Nama Kategori</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <span id="error-edit_name" class="text-danger small"></span>
                        <div>
                            <label for="edit_color">Warna</label>
                            <input type="color" class="form-control" id="edit_color" name="color" default="#000000">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-foot')
    <script>
        function initTableKategorilisensi() {
            $('#tableKategorilisensi').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.setting_attr.kategorilisensi.get_kategorilisensi') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            return '<span class="badge" style="border:1px solid; color:' + row.color + '">' + data + '</span>';
                        }
                    },
                    {
                        data: null,
                        name: 'timestamp',
                        render: function(data) {
                            return `
                                <small class="text-muted">Dibuat: ${moment(data.created_at).format('DD MMM YYYY HH:mm')}</small><br>
                                <small class="text-muted">Diperbarui: ${moment(data.updated_at).format('DD MMM YYYY HH:mm')}</small>
                            `;
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'asc']],
            });
        }

        $(document).ready(function() {
            initTableKategorilisensi();

            $('#btnOpenCreateModal').on('click', function() {
                $('#createModal').modal('show');
            });

            $('#formCreateKategorilisensi').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: "{{ route('admin.setting_attr.kategorilisensi.store') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#createModal').modal('hide');
                        $('#tableKategorilisensi').DataTable().ajax.reload();
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON?.message === 'The name has already been taken.') {
                            Swal.fire({ icon: 'warning', title: 'Gagal', text: 'Kategori dengan nama tersebut sudah ada.' });
                        } else if (xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#error-' + key).text(value[0]);
                            });
                            Swal.fire({ icon: 'warning', title: 'Gagal', text: 'Nama kategori sudah ada.' });
                        }
                        return false;
                    }
                });
            });
        });

        $('#tableKategorilisensi').on('click', '#edit-kategorilisensi', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const color = $(this).data('color');

            $('#editModal .modal-title').text('Edit Kategori Lisensi (ID: ' + id + ' - ' + name + ')');
            $('#edit_name').attr('placeholder', name);
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ url('/admin/setting_attr/kategorilisensi/edit') }}/" + id,
                type: 'GET',
                success: function(response) {
                    $('#edit_name').val(response.name);
                    $('#formEditKategorilisensi').data('id', response.id);
                    $('#edit_color').val(response.color);
                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat mengambil data.' });
                }
            });
        });

        $('#formEditKategorilisensi').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = $(this).data('id');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ url('/admin/setting_attr/kategorilisensi/update') }}/" + id,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#editModal').modal('hide');
                    $('#tableKategorilisensi').DataTable().ajax.reload();
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                },
                error: function(xhr) {
                    if (xhr.responseJSON?.message === 'The name has already been taken.') {
                        Swal.fire({ icon: 'warning', title: 'Gagal', text: 'Kategori dengan nama tersebut sudah ada.' });
                    } else if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#error-edit_' + key).text(value[0]);
                        });
                        Swal.fire({ icon: 'warning', title: 'Gagal', text: 'Nama kategori sudah ada.' });
                    }
                    return false;
                }
            });
        });

        $('#tableKategorilisensi').on('click', '#delete-kategorilisensi', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data kategori "' + name + '"?',
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
                        url: "{{ url('/admin/setting_attr/kategorilisensi/delete') }}/" + id,
                        type: 'DELETE',
                        success: function(response) {
                            $('#tableKategorilisensi').DataTable().ajax.reload();
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                        },
                        error: function(xhr) {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat menghapus data.' });
                        }
                    });
                }
            });
        });
    </script>
@endpush