@extends('layouts.backsite', [
    'title' => 'User Manager | SAPA PPL',
    'welcome' => 'Manajemen Pengguna',
    'breadcrumb' => '<li class="breadcrumb-item active">User Manager</li>',
])

@push('script-head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    {{-- DataTable Css --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-computer"></i> Daftar Pengguna <span class="badge end-0 mr-3 bg-info text-light">{{ $totalUsers }}</span></h3>
                            <button type="button" id="btnOpenCreateModal" class="btn btn-outline-primary" style="margin-left: auto;" data-toggle="tooltip" data-placement="top" title="Tambah Data">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 mt-auto">
                                    <div class="px-2 d-flex">
                                        <select id="roles" name="roles" class="ml-0 form-control mr-2">
                                            <option value="">Semua Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ request('roles') == $role->id ? 'selected' : '' }}>
                                                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                                    {{-- {{ $role->name }} --}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="ml-0 btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Filter"><i class="fas fa-filter"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="tableUsers" class="table table-bordered table-striped table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Nama Lengkap</th>
                                            <th>Email</th>
                                            <th>Tanggal Registrasi</th>
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

        {{-- Create Modals --}}
        <div id="createModal" class="modal fade" tabindex="-1" aria-hidden="true" data-backdrop="static" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Form Tambah User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="formCreateUser" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                {{-- Full Name --}}
                                <div class="form-group col-12">
                                    <label for="fullname">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="fullname" id="fullname" class="form-control">
                                    <span class="text-danger small" id="error-fullname"></span>
                                </div>

                                {{-- Username --}}
                                <div class="form-group col-12">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" class="form-control">
                                    <span class="text-danger small" id="error-username"></span>
                                </div>

                                {{-- Email --}}
                                <div class="form-group col-12">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control">
                                    <span class="text-danger small" id="error-email"></span>
                                </div>

                                {{-- Password --}}
                                <div class="form-group col-12">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control">
                                    <span class="text-danger small" id="error-password"></span>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="form-group col-12">
                                    <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                    <span class="text-danger small" id="error-password_confirmation"></span>
                                </div>

                                {{-- Image Upload --}}
                                <div class="form-group col-12">
                                    <label for="avatar">Upload Avatar</label>
                                    <input type="file" name="avatar" id="avatar" class="form-control" accept="image/jpeg,image/jpg,image/png">
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG (Max: 2MB)</small>
                                    <span class="text-danger small" id="error-avatar"></span>
                                </div>

                                {{-- Role --}}
                                <div class="form-group col-12">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select name="role" id="role" class="form-control select2">
                                        <option value="" disabled selected>-- Pilih Role --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ ucwords(str_replace('_', ' ', $role->name)) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger small" id="error-role"></span>
                                </div>

                            </div>
                            <p class="text-muted">Tanda <span class="text-danger">*</span> wajib diisi</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" id="btnResetForm">Reset</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseModal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Modals --}}
        <div id="editModal" class="modal fade" data-backdrop="static" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="" id="formEditUser" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="row">
                                {{-- Full Name --}}
                                <div class="form-group col-12">
                                    <label for="edit_fullname">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="fullname" id="edit_fullname" class="form-control">
                                    <span class="text-danger small" id="error-edit_fullname"></span>
                                </div>

                                {{-- Username --}}
                                <div class="form-group col-12">
                                    <label for="edit_username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="edit_username" class="form-control" readonly>
                                    <span class="text-danger small" id="error-edit_username"></span>
                                </div>

                                {{-- Email --}}
                                <div class="form-group col-12">
                                    <label for="edit_email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="edit_email" class="form-control">
                                    <span class="text-danger small" id="error-edit_email"></span>
                                </div>

                                {{-- Password --}}
                                <div class="form-group col-12">
                                    <label for="edit_password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="edit_password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                                    <span class="text-danger small" id="error-edit_password"></span>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="form-group col-12">
                                    <label for="edit_password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="edit_password_confirmation" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                                    <span class="text-danger small" id="error-edit_password_confirmation"></span>
                                </div>

                                {{-- Image Upload --}}
                                <div class="form-group col-6">
                                    <label for="edit_avatar">Ganti Avatar</label>
                                    <input type="file" name="avatar" id="edit_avatar" class="form-control" accept="image/jpeg,image/jpg,image/png">
                                    <span class="text-danger small" id="error-edit_avatar"></span>
                                </div>
                                <div class="form-group col-6">
                                    <label>Preview Avatar Saat Ini</label><br>
                                    <img id="currentAvatarPreview" src="" alt="Preview Avatar" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                    <span class="text-danger small" id="error-edit_avatar"></span>
                                </div>

                                {{-- Role --}}
                                <div class="form-group col-12">
                                    <label for="edit_role">Role <span class="text-danger">*</span></label>
                                    <select name="role" id="edit_role" class="form-control select2">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ ucwords(str_replace('_', ' ', $role->name)) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger small" id="error-edit_role"></span>
                                </div>

                            </div>
                            <p class="text-muted">Tanda <span class="text-danger">*</span> wajib diisi</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" id="btnResetForm">Reset</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCloseModal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    @push('script-foot')
        <script>
            function initTableUsers() {
                $('#tableUsers').DataTable({
                    layout: {
                        topEnd: {
                            search: {
                                placeholder: 'Username'
                            }
                        }
                    },
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('admin.settings.usermanager.get_users') }}",
                        data: function(d) {
                            d.roles = $('#roles').val();
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'fullname',
                            name: 'fullname'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: null,
                            name: 'timestamp',
                            render: function(data) {
                                return `<span class="text-muted small">Dibuat: ${moment(data.created_at).format('lll')} <br>
                            Diupdate: ${moment(data.updated_at).format('lll')}</span>`;
                            },
                            orderable: false,
                            searchable: false
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
                    ]
                });
            }

            $('#roles').on('change', function() {
                $('#tableUsers').DataTable().ajax.reload();
            });

            $(document).ready(function() {
                initTableUsers();
            });
        </script>

        <script>
            // Modal Management

            // Handle Tambah User Modal
            $('#btnOpenCreateModal').on('click', function() {
                $('#createModal').modal('show');
                $('#formCreateUser')[0].reset(); // Reset form fields
            });

            // Handle Submit
            $(document).ready(function() {
                $('#formCreateUser').on('submit', function(e) {
                    e.preventDefault();
                    // const form = $(this);
                    const formData = new FormData(this);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('admin.settings.usermanager.store') }}",
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data berhasil disimpan!',
                            }).then(() => {
                                $('#createModal').modal('hide');
                                $('#formCreateUser')[0].reset(); // Reset form fields
                                $('#tableUsers').DataTable().ajax.reload();
                            });

                        },
                        error: function(xhr) {
                            if (xhr.responseJSON?.errors) {
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    $(`#error-${key}`).text(value[0]);
                                });
                            }
                            return false;
                        }
                    });
                });
            });

            // Handle Edit Klasifikasi
            $('#tableUsers').on('click', '#edit-user', function() {
                const id = $(this).data('id');
                const username = $(this).data('name');

                $('#editModal .modal-title').text('Form Edit User (ID: ' + id + ' - ' + username + ')');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ url('/admin/settings/usermanager/edit') }}/${id}`,
                    type: 'GET',
                    success: function(response) {
                        $('#edit_fullname').val(response.fullname);
                        $('#edit_username').val(response.username);
                        $('#edit_email').val(response.email);
                        $('#edit_password').val('');
                        $('#edit_password_confirmation').val('');
                        $('#currentAvatarPreview').attr('src', '{{ asset('storage') }}/' + response.avatar);
                        $('#edit_role').val(response.roles[0]?.name).trigger('change');

                        $('#editModal').modal('show'); // Buka modal edit
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat mengambil data kategori.',
                        });
                    }
                });
            });

            // Handle Delete
            $('#tableUsers').on('click', '#delete-user', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus user "${name}"?`,
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
                            url: `{{ url('/admin/settings/usermanager/delete') }}/${id}`,
                            type: 'DELETE',
                            success: function(response) {
                                $('#tableUsers').DataTable().ajax.reload();
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
                                    text: `Terjadi kesalahan saat menghapus user "${name}".`,
                                });
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
