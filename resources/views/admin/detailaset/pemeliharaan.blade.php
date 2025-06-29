@extends('layouts.backsite-navtab-aset', [
    'id' => $asset->id ?? '',
    'classification_id' => $asset->classification_id ?? '',
])

@push('script-head')
    @stack('script-head')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content-tab')
    <div class="container-fluid">
        <div class="row align-items-center">
            <p class="col-12 h4 d-flex justify-content-center"><u>{{ $asset->tag }} - {{ $asset->name }}</u></p>
            <p class="col-8 h4">Jadwal Pemeliharaan</p>
            <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="showModalAddJadwalPemeliharaan()"><i class="fa-regular fa-clock"></i> + Jadwal</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="tableJadwalPemeliharaan">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Tugas</th>
                        <th>Frekuensi</th>
                        <th>Jadwal Mulai</th>
                        <th>Jadwal Berikutnya</th>
                        <th>Status</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <hr class="my-4" />

        <div class="row align-items-center mt-3">
            <p class="col-8 h4">Daftar Pemeliharaan Korektif</p>
            {{-- <span class="col-8 ">{{ $assets->tag }} - {{ $assets->name }}</span> --}}
            {{-- <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPemeliharaan"><i class="fa-regular fa-clock"></i> Jadwal</button>
            </div> --}}
            <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="showModalPemeliharaan()"><i class="fa-solid fa-screwdriver-wrench"></i> + Pemeliharaan</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="tablePemeliharaan">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Tanggal Mulai</th>
                        <th>Petugas</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        @include('admin.modals.add_preventif_modal')
        @include('admin.modals.edit_preventif_modal')
        {{-- @include('admin.modals.korektif_rt_modal') --}}


    </div>
@endsection

@push('script-foot')
    <script>
        $('#start_date').datepicker({
            changeMonth: true,
            changeYear: true,
            // format: "dd/mm/yyyy"
            format: "yyyy-mm-dd"
        });

        $('#edit_start_date').datepicker({
            changeMonth: true,
            changeYear: true,
            // format: "dd/mm/yyyy"
            format: "yyyy-mm-dd"
        });
    </script>

    {{-- Handle Jadwal Pemeliharaan Preventif --}}
    <script>
        function showModalAddJadwalPemeliharaan() {
            $('#add-schedule').modal('show');
        }

        function showModalEditJadwalPemeliharaan(id) {
            $.ajax({
                url: "{{ route('admin.asetrt.pemeliharaan.preventifEdit', ['id' => ':id']) }}".replace(':id', id),
                type: "GET",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#edit_id').val('');
                    $('#edit_name').val('');
                    $('#edit_frequency').val('');
                    $('#edit_start_date').val('');
                    $('#edit_next_date').val('');
                    $('#edit_status').val('');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengambil data jadwal pemeliharaan.',
                    });
                },
                success: function(data) {
                    $('#edit_id').val(data.id);
                    $('#edit_name').val(data.name);
                    $('#edit_frequency').val(data.frequency);
                    $('#edit_start_date').val(data.start_date);
                    $('#edit_next_date').val(data.next_date);
                    $('#edit_status').val(data.status);
                }
            });
            $('#edit-schedule').modal('show');
        }

        function deleteJadwalPemeliharaan(id) {
            Swal.fire({
                title: 'Hapus Jadwal Pemeliharaan',
                text: "Apakah Anda yakin ingin menghapus jadwal pemeliharaan dengan ID " + id + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.asetrt.pemeliharaan.preventifDelete', ['id' => ':id']) }}".replace(':id', id),
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "DELETE",
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                'Jadwal pemeliharaan telah dihapus.',
                                'success'
                            );
                            $('#tableJadwalPemeliharaan').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Gagal!',
                                'Jadwal pemeliharaan gagal dihapus.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        // Handle Tabel Pemeliharaan Preventif
        $(document).ready(function() {
            tableJadwalPemeliharaan();
        });

        function tableJadwalPemeliharaan() {
            $('#tableJadwalPemeliharaan').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.asetrt.pemeliharaan.preventifdataTable', $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'frequency',
                        name: 'frequency',
                        render: function(data) {
                            let arr = {
                                "3": "<i class='fa-regular fa-bell'></i> 3 bulan sekali",
                                "4": "4 bulan sekali",
                                "6": "6 bulan sekali",
                                "12": "12 bulan sekali",
                            };
                            return arr[data];
                        }
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        render: function(data, type, row) {
                            let date = new Date(data);
                            return moment(data).format('ll');
                        }
                    },
                    {
                        data: 'next_date',
                        name: 'next_date',
                        render: function(data, type, row) {
                            let date = new Date(data);
                            let sisaHari = Math.ceil((new Date(data) - new Date()) / (1000 * 60 * 60 * 24));
                            return moment(data).format('ll') + ` <span class="badge badge-info"><i class="fa-solid fa-stopwatch"></i> ${sisaHari} hari lagi</span>`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        }
    </script>

    {{-- Handle Pemeliharaan Korektif --}}
    <script>
        function showModalAddPemeliharaan() {
            $('#modalPemeliharaan').modal('show');
            $('#modalPemeliharaanLabel').text('Tambah Pemeliharaan Korektif');
            $('#submitPemeliharaan').text('Jadwalkan');
        }

        $(document).ready(function() {
            tablePemeliharaan();
        });

        function tablePemeliharaan() {
            $('#tablePemeliharaan').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.asetrt.pemeliharaan.korektifdataTable', $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'next_date',
                        name: 'next_date'
                    },
                    {
                        data: 'technician_id',
                        name: 'technician_id'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        }
    </script>
    {{-- @stack('script-foot') --}}
@endpush
