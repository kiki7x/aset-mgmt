@extends('layouts.backsite', [
    'title' => 'Setting Lokasi | SAPA PPL',
    'welcome' => 'Setting Lokasi',
    'breadcrumb' => '
        <li class="breadcrumb-item"><a href="/admin/setting_attr">Setting Atribut</a></li>
        <li class="breadcrumb-item active">Lokasi</li>',
])

@push('script-head')
    {{-- DataTable Css --}}
    {{-- <link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets\plugins\datatables-rowgroup\css\rowGroup.bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa-solid fa-building"></i> Daftar Gedung & Ruangan</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm mr-2 d-inline-flex" style="width: 260px;">
                            <input type="text" id="buildingRoomSearch" class="form-control" placeholder="Cari gedung atau ruangan">
                            <div class="input-group-append">
                                <button type="button" id="btnClearBuildingRoomSearch" class="btn btn-outline-secondary" title="Bersihkan pencarian">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="btnRefreshBuildingRooms" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Refresh daftar gedung/ruangan">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <button type="button" id="btnOpenTambahGedung" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Tambah Data" data-crud="true">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="buildingRoomsAccordion" class="accordion"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Building --}}
    <div id="editBuildingModal" title="Edit Gedung" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gedung</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formEditGedung">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="edit_building_id" name="building_id" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_building_name">Nama Gedung</label>
                            <input type="text" class="form-control" id="edit_building_name" name="name" required>
                        </div>
                        <span id="error-edit_building_name" class="text-danger small"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Ruangan --}}
    <div id="editRuanganModal" title="Edit Ruangan" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Ruangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formEditRuangan">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="edit_room_id" name="room_id" />
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_room_name">Nama Ruangan</label>
                            <input type="text" class="form-control" id="edit_room_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_room_floor">Lantai</label>
                            <input type="text" class="form-control" id="edit_room_floor" name="floor" required>
                        </div>
                        <span id="error-edit_room_name" class="text-danger small"></span>
                        <span id="error-edit_room_floor" class="text-danger small"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Gedung --}}
    <div id="modalTambahGedung" title="Tambah Gedung" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
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

    {{-- Modal tambah ruangan --}}
    <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="addRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoomModalLabel">Tambah Ruangan di Gedung ...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addRoomForm">
                    <input type="hidden" id="roomBuildingId" name="building_id">
                    <div class="form-group">
                        <label for="roomNameInput">Nama Ruangan</label>
                        <input type="text" class="form-control" id="roomNameInput" name="name" placeholder="Masukkan nama ruangan" required>
                    </div>
                    <div class="form-group">
                        <label for="roomFloorInput">Lantai</label>
                        <input type="text" class="form-control" id="roomFloorInput" name="floor" placeholder="Masukkan lantai" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" form="addRoomForm" id="addRoomBtn" class="btn btn-primary">Tambah</button>
            </div>
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
        // Initialize building and room list
        $(document).ready(function() {
            initBuildingRoomList();

            // Handle refresh gedung / ruangan
            $('#btnRefreshBuildingRooms').on('click', function() {
                initBuildingRoomList();
            });

            $('#buildingRoomSearch').on('input', function() {
                applyBuildingRoomFilter();
            });

            $('#btnClearBuildingRoomSearch').on('click', function() {
                $('#buildingRoomSearch').val('');
                applyBuildingRoomFilter();
            });

            $('#btnOpenTambahGedung').on('click', function() {
                $('#formCreateGedung')[0].reset();
                $('#error-name').text('');
                $('#modalTambahGedung').modal('show');
            });

            // Handle Edit Gedung
            $('#buildingRoomsAccordion').on('click', '.btn-edit-building', function(e) {
                e.stopPropagation();
                const id = $(this).data('building-id');
                const name = $(this).data('building-name');
                $('#edit_building_id').val(id);
                $('#edit_building_name').val(name);
                $('#error-edit_building_name').text('');
                $('#editBuildingModal').modal('show');
            });

            $('#buildingRoomsAccordion').on('click', '.btn-add-room', function(e) {
                e.stopPropagation();
                const buildingId = $(this).data('building-id');
                const buildingName = $(this).data('building-name');
                $('#addRoomModalLabel').text(`Tambah Ruangan di Gedung ${buildingName}`);
                $('#addRoomForm')[0].reset();
                $('#addRoomForm input[name="building_id"]').val(buildingId);
                $('#addRoomModal').modal('show');
            });

            // Handle Edit Ruangan
            $('#buildingRoomsAccordion').on('click', '.btn-edit-room', function(e) {
                e.stopPropagation();
                const id = $(this).data('room-id');
                const name = $(this).data('room-name');
                const floor = $(this).data('room-floor');
                $('#edit_room_id').val(id);
                $('#edit_room_name').val(name);
                $('#edit_room_floor').val(floor);
                $('#error-edit_room_name').text('');
                $('#error-edit_room_floor').text('');
                $('#editRuanganModal').modal('show');
            });

            $('#formCreateGedung').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ url('admin/setting_attr/lokasi/building/store') }}`,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#modalTambahGedung').modal('hide');
                        initBuildingRoomList();
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message,
                        });
                        $('#formCreateGedung')[0].reset();
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

            $('#addRoomForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ url('admin/setting_attr/lokasi/room/store') }}`,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#addRoomModal').modal('hide');
                        initBuildingRoomList();
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message,
                        });
                        $('#addRoomForm')[0].reset();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi gagal',
                                text: errors.name ? errors.name[0] : (errors.floor ? errors.floor[0] : 'Periksa isian ruangan.'),
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal menambahkan ruangan.',
                            });
                        }
                    }
                });
            });

            // Handle Edit Gedung
            $('#formEditGedung').on('submit', function(e) {
                e.preventDefault();
                const id = $('#edit_building_id').val();
                const formData = new FormData(this);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ url('admin/setting_attr/lokasi/building/update') }}/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#editBuildingModal').modal('hide');
                        initBuildingRoomList();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $('#error-edit_building_name').text(errors.name ? errors.name[0] : '');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memperbarui nama gedung.',
                            });
                        }
                    }
                });
            });

            $('#formEditRuangan').on('submit', function(e) {
                e.preventDefault();
                const id = $('#edit_room_id').val();
                const formData = new FormData(this);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ url('admin/setting_attr/lokasi/update') }}/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#editRuanganModal').modal('hide');
                        initBuildingRoomList();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $('#error-edit_room_name').text(errors.name ? errors.name[0] : '');
                            $('#error-edit_room_floor').text(errors.floor ? errors.floor[0] : '');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memperbarui ruangan.',
                            });
                        }
                    }
                });
            });

            // Handle Delete Gedung
            $('#buildingRoomsAccordion').on('click', '.btn-delete-building', function(e) {
                e.stopPropagation();
                const id = $(this).data('building-id');
                const name = $(this).data('building-name');

                Swal.fire({
                    title: `Hapus gedung ${name}?`,
                    text: 'Aksi ini juga akan menghapus ruangan terkait jika ada. Lanjutkan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: `{{ url('admin/setting_attr/lokasi/building/delete') }}/${id}`,
                            type: 'DELETE',
                            success: function(response) {
                                initBuildingRoomList();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Gagal menghapus gedung.',
                                });
                            }
                        });
                    }
                });
            });

            // Handle Delete Ruangan
            $('#buildingRoomsAccordion').on('click', '.btn-delete-room', function(e) {
                e.stopPropagation();
                const id = $(this).data('room-id');
                const name = $(this).data('room-name');

                Swal.fire({
                    title: `Hapus ruangan ${name}?`,
                    text: 'Aksi ini tidak dapat dibatalkan. Lanjutkan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: `{{ url('admin/setting_attr/lokasi/delete') }}/${id}`,
                            type: 'DELETE',
                            success: function(response) {
                                initBuildingRoomList();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Gagal menghapus ruangan.',
                                });
                            }
                        });
                    }
                });
            });
        });

        function initBuildingRoomList() {
            const accordion = $('#buildingRoomsAccordion');
            accordion.html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Memuat daftar gedung...</div>');

            $.getJSON(`{{ url('admin/setting_attr/lokasi/get_lokasi') }}`, function(response) {
                const buildings = response.data || [];

                if (!buildings.length) {
                    accordion.html('<div class="text-muted">Tidak ada data gedung atau ruangan.</div>');
                    return;
                }

                let html = '';
                buildings.forEach(function(item, index) {
                    const building = item.building || {};
                    const rooms = item.locations || [];
                    const count = rooms.length;
                    const collapseId = 'buildingRoomsCollapse' + index;

                    html += `<div class="card">
                        <div class="card-header p-0" id="heading-${index}">
                            <div class="d-flex justify-content-between align-items-center p-2">
                                <button class="btn btn-link flex-grow-1 text-left mb-0 p-0" type="button" data-toggle="collapse" data-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                                    <strong>${index + 1}. ${escapeHtml(building.name || 'Gedung Tidak Diketahui')}</strong> <small class="text-muted">(${count} ruangan)</small>
                                    <span class="text-muted"><i class="fas fa-chevron-down"></i></span>
                                </button>
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-add-room" data-building-id="${building.id || ''}" data-building-name="${escapeHtml(building.name || '')}" title="Tambah Ruangan" data-crud="true">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mr-2 btn-edit-building" data-building-id="${building.id || ''}" data-building-name="${escapeHtml(building.name || '')}" title="Edit Gedung" data-crud="true">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-building" data-building-id="${building.id || ''}" data-building-name="${escapeHtml(building.name || '')}" title="Hapus Gedung" data-crud="true">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="${collapseId}" class="collapse" aria-labelledby="heading-${index}" data-parent="#buildingRoomsAccordion">
                            <div class="card-body p-3">
                                ${rooms.length ? `<ul class="list-group">
                                    ${rooms.map(function(room, roomIndex) {
                                        const roomFloor = room.floor ? `Lantai ${escapeHtml(room.floor)}` : 'Lantai -';
                                        return `<li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>${roomIndex + 1}. ${escapeHtml(room.name || '')}</strong><br>
                                                <small class="text-muted">${roomFloor}</small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit-room" data-room-id="${room.id || ''}" data-room-name="${escapeHtml(room.name || '')}" data-room-floor="${escapeHtml(room.floor || '')}" title="Edit Ruangan" data-crud="true">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger ml-2 btn-delete-room" data-room-id="${room.id || ''}" data-room-name="${escapeHtml(room.name || '')}" title="Hapus Ruangan" data-crud="true">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </li>`;
                                    }).join('')}
                                </ul>` : '<div class="text-muted">Belum ada ruangan di gedung ini.</div>'}
                            </div>
                        </div>
                    </div>`;
                });

                accordion.html(html);
                applyBuildingRoomFilter();
            }).fail(function() {
                accordion.html('<div class="text-danger">Gagal memuat daftar gedung. Coba refresh ulang.</div>');
            });
        }

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function applyBuildingRoomFilter() {
            const keyword = $('#buildingRoomSearch').val().trim().toLowerCase();
            const cards = $('#buildingRoomsAccordion .card');

            if (!keyword) {
                cards.show();
                return;
            }

            cards.each(function() {
                const text = $(this).text().toLowerCase();
                $(this).toggle(text.indexOf(keyword) !== -1);
            });
        }

    </script>
@endpush
