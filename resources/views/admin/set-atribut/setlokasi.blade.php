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
                        <button type="button" id="btnRefreshBuildingRooms" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Refresh daftar gedung/ruangan">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <button type="button" id="btnOpenTambahGedung" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Tambah Data">
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
                    <div class="form-group">
                        <label for="roomNameInput">Nama Ruangan</label>
                        <input type="text" class="form-control" id="roomNameInput" name="roomName" placeholder="Masukkan nama ruangan">
                    </div>
                    <div class="form-group">
                        <label for="roomFloorInput">Lantai</label>
                        <input type="text" class="form-control" id="roomFloorInput" name="roomFloor" placeholder="Masukkan lantai">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" id="addRoomBtn" class="btn btn-primary">Tambah</button>
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
                $('#editRuanganModal').modal('show');
            });

            // Handle Tambah Gedung
            $('#btnOpenTambahGedung').on('click', function() {
                $('#modalTambahGedung').modal('show');
            });
            $('#formTambahGedung').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `{{ url('admin/setting_attr/lokasi/store') }}`,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#modalTambahGedung').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Model berhasil ditambahkan.',
                        });
                        $('#formTambahGedung')[0].reset();
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
                        initTableModel();
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
        });

        function initBuildingRoomList() {
            const accordion = $('#buildingRoomsAccordion');
            accordion.html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Memuat daftar gedung...</div>');

            $.getJSON(`{{ url('admin/setting_attr/lokasi/get_lokasi') }}`, function(response) {
                const rows = response.data || response;
                const buildings = {};

                rows.forEach(function(item) {
                    const buildingName = item.building ? item.building.name : 'Gedung Tidak Diketahui';
                    if (!buildings[buildingName]) {
                        buildings[buildingName] = [];
                    }
                    buildings[buildingName].push(item);
                });

                if ($.isEmptyObject(buildings)) {
                    accordion.html('<div class="text-muted">Tidak ada data gedung atau ruangan.</div>');
                    return;
                }

                let html = '';
                let index = 0;
                let roomIndex = 0;
                Object.keys(buildings).forEach(function(buildingName, index) {
                    index++;
                    roomIndex = 0;
                    const rooms = buildings[buildingName];
                    const count = rooms.length;
                    const collapseId = 'buildingRoomsCollapse' + index;

                    html += `<div class="card">
                        <div class="card-header p-0" id="heading-${index}">
                            <div class="d-flex justify-content-between align-items-center p-2">
                                <button class="btn btn-link flex-grow-1 text-left mb-0 p-0" type="button" data-toggle="collapse" data-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                                    <strong>${index}. ${buildingName}</strong> <small class="text-muted">(${count} ruangan)</small>
                                    <span class="text-muted"><i class="fas fa-chevron-down"></i></span>
                                </button>
                                <div class="d-flex align-items-center">
                                    {{-- Tambah Ruangan --}}
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-add-room" data-building-name="${buildingName}" data-toggle="modal" data-target="#addRoomModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    {{-- Edit Gedung --}}
                                    <button type="button" class="btn btn-sm btn-outline-secondary mr-2 btn-edit-building" data-building-id="${rooms[0].building.id}" data-building-name="${buildingName}" title="Edit Gedung">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="${collapseId}" class="collapse" aria-labelledby="heading-${index}" data-parent="#buildingRoomsAccordion">
                            <div class="card-body p-3">
                                <ul class="list-group">
                                    ${rooms.map(room => {
                                        roomIndex++;
                                        const roomFloor = room.floor ? `Lantai ${room.floor}` : 'Lantai -';
                                        return `<li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>${roomIndex}. ${room.name}</strong><br>
                                                <small class="text-muted">${roomFloor}</small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                {{-- tombol edit ruangan --}}
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-edit-room" data-room-id="${room.id}" data-room-name="${room.name}" data-room-floor="${room.floor || ''}" title="Edit Ruangan">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                            </div>
                                        </li>`;
                                    }).join('')}
                                </ul>
                            </div>
                        </div>
                    </div>`;
                });

                accordion.html(html);
            }).fail(function() {
                accordion.html('<div class="text-danger">Gagal memuat daftar gedung. Coba refresh ulang.</div>');
            });
        }

    </script>
@endpush
