@extends('layouts.backsite', [
    'title' => 'Permission Manager | SAPA PPL',
    'welcome' => 'Manajemen Permission & Role',
    'breadcrumb' => '
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Permission</li>
    ',
])

@push('script-head')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex bd-highlight">
            <h3 class="card-title font-weight-bold mr-auto p-2 bd-highlight"><i class="fa-solid fa-shield-halved"></i> Daftar Role <span class="badge bg-info text-light">{{ count($roles) }}</span></h3>
            <div>
                <button class="btn btn-outline-primary" onclick="openModalCreate()" data-toggle="tooltip" data-placement="top" title="Tambah Role"><i class="fa-regular fa-plus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableRoles" class="table table-bordered table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Role</th>
                            <th>Guard</th>
                            <th>Jumlah User</th>
                            <th>Jumlah Permission</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Atur Permission --}}
    <div class="modal fade" data-backdrop="static" id="modalPermission" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formPermission">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row">
                            @foreach($permissions as $group => $items)
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <div class="card-header py-2">
                                        <div class="form-check">
                                            <input class="form-check-input select-all" type="checkbox" data-group="{{ $group }}">
                                            <label class="form-check-label font-weight-bold">
                                                {{ ucwords(str_replace(['-', '_'], ' ', $group)) }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-body py-2">
                                        @php
                                            $sorted = $items->sortBy(function($p) {
                                                $order = ['view' => 0, 'create' => 1, 'edit' => 2, 'delete' => 3];
                                                $action = substr($p->name, strrpos($p->name, '-') + 1);
                                                return $order[$action] ?? 99;
                                            });
                                        @endphp
                                        @foreach($sorted as $perm)
                                        <div class="form-check form-check-inline mr-3">
                                            <input class="form-check-input perm-checkbox" type="checkbox" name="permissions[]" value="{{ $perm->id }}" data-group="{{ $group }}" id="perm_{{ $perm->id }}">
                                            <label class="form-check-label" for="perm_{{ $perm->id }}">
                                                @php
                                                    $action = substr($perm->name, strrpos($perm->name, '-') + 1);
                                                    $labels = ['view' => 'Lihat', 'create' => 'Tambah', 'edit' => 'Edit', 'delete' => 'Hapus'];
                                                @endphp
                                                {{ $labels[$action] ?? $action }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Create/Edit Role --}}
    <div class="modal fade" data-backdrop="static" id="modalRole" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formRole">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="mb-n1" for="roleName">Nama Role <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="roleName" class="form-control" placeholder="contoh: admin_tik">
                            <small class="form-text text-muted">Akan otomatis di-slug: spasi → underscore, huruf besar → kecil</small>
                            <span class="text-danger small" id="error-name"></span>
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
<script>
    let tableRoles;

    function initTableRoles() {
        tableRoles = $('#tableRoles').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            ajax: {
                url: "{{ route('admin.settings.permission.get_roles') }}",
                dataSrc: 'data'
            },
            columns: [
                { data: 'id', name: 'id' },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data) {
                        return ucwords(data.replace(/_/g, ' '));
                    }
                },
                { data: 'guard_name', name: 'guard_name' },
                { data: 'users_count', name: 'users_count' },
                { data: 'permissions_count', name: 'permissions_count' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown"></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><span class="mx-3" onclick="openModalPermission(${row.id})" style="cursor:pointer;color:#007bff;">Atur Permission</span></li>
                                    <li><span class="mx-3" onclick="openModalEditRole(${row.id})" style="cursor:pointer;color:#007bff;">Edit Role</span></li>
                                    <li><span class="mx-3" onclick="openModalDelete(${row.id}, '${row.name}')" style="cursor:pointer;color:#dc3545;">Hapus Role</span></li>
                                </ul>
                            </div>
                        `;
                    }
                }
            ],
            order: [[0, 'asc']]
        });
    }

    function ucwords(str) {
        return str.replace(/\b\w/g, function(l) { return l.toUpperCase(); });
    }

    $(document).ready(function() {
        initTableRoles();
    });

    // Modal Permission
    function openModalPermission(id) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `{{ url('/admin/settings/permission') }}/${id}/edit`,
            type: 'GET',
            success: function(response) {
                $('.perm-checkbox').prop('checked', false);
                $('.select-all').prop('checked', false);
                response.permissionIds.forEach(function(id) {
                    $(`.perm-checkbox[value="${id}"]`).prop('checked', true);
                });
                $('#modalPermission').data('id', id).modal('show');
                $('#modalPermission .modal-title').text('Atur Permission: ' + ucwords(response.role.name.replace(/_/g, ' ')));
                updateSelectAll();
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memuat data permission.' });
            }
        });
    }

    $('.select-all').on('change', function() {
        const group = $(this).data('group');
        $(`.perm-checkbox[data-group="${group}"]`).prop('checked', $(this).prop('checked'));
    });

    $(document).on('change', '.perm-checkbox', function() {
        updateSelectAll();
    });

    function updateSelectAll() {
        $('.select-all').each(function() {
            const group = $(this).data('group');
            const total = $(`.perm-checkbox[data-group="${group}"]`).length;
            const checked = $(`.perm-checkbox[data-group="${group}"]:checked`).length;
            $(this).prop('checked', total > 0 && total === checked);
            $(this).prop('indeterminate', checked > 0 && checked < total);
        });
    }

    $('#formPermission').on('submit', function(e) {
        e.preventDefault();
        var id = $('#modalPermission').data('id');
        var permissions = $('.perm-checkbox:checked').map(function() { return $(this).val(); }).get();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `{{ url('/admin/settings/permission') }}/${id}/update`,
            type: 'POST',
            data: {
                _method: 'PATCH',
                permissions: permissions
            },
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message })
                    .then(function() {
                        $('#modalPermission').modal('hide');
                        tableRoles.ajax.reload();
                    });
            },
            error: function(xhr) {
                Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON?.message || 'Terjadi kesalahan.' });
            }
        });
    });

    // Modal Create/Edit Role
    function openModalCreate() {
        $('#formRole')[0].reset();
        $('#formRole').attr('data-mode', 'create').removeData('id');
        $('#roleName').prop('readonly', false);
        $('#modalRole .modal-title').text('Tambah Role');
        $('#modalRole').modal('show');
    }

    function openModalEditRole(id) {
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `{{ url('/admin/settings/permission') }}/${id}/edit`,
            type: 'GET',
            success: function(response) {
                $('#formRole')[0].reset();
                $('#formRole').attr('data-mode', 'edit').data('id', id);
                $('#roleName').val(response.role.name).prop('readonly', false);
                $('#modalRole .modal-title').text('Edit Role');
                $('#modalRole').modal('show');
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memuat data role.' });
            }
        });
    }

    $('#formRole').on('submit', function(e) {
        e.preventDefault();
        var mode = $(this).attr('data-mode');
        var id = $(this).data('id');
        var formData = new FormData(this);

        if (mode === 'edit') {
            formData.append('_method', 'PATCH');
        }

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: mode === 'create'
                ? "{{ route('admin.settings.permission.store') }}"
                : `{{ url('/admin/settings/permission') }}/${id}/update`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message })
                    .then(function() {
                        $('#modalRole').modal('hide');
                        tableRoles.ajax.reload();
                    });
            },
            error: function(xhr) {
                if (xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#error-' + key).text(value[0]);
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON?.message || 'Terjadi kesalahan.' });
                }
            }
        });
    });

    // Delete via Swal
    function openModalDelete(id, name) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus role "${ucwords(name.replace(/_/g, ' '))}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: `{{ url('/admin/settings/permission') }}/${id}/destroy`,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message })
                            .then(function() { tableRoles.ajax.reload(); });
                    },
                    error: function(xhr) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON?.message || 'Terjadi kesalahan.' });
                    }
                });
            }
        });
    }
</script>
@endpush
