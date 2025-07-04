@extends('layouts.backsite-navtab-aset', [
    'id' => $asset->id ?? '',
    'classification_id' => $asset->classification_id ?? '',
])

@push('script-head')
    @stack('script-head')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content-tab')
    <div class="container-fluid">
        <div class="row align-items-center">
            <p class="col-12 h4 d-flex justify-content-center"><u>{{ $asset->tag }} - {{ $asset->name }}</u></p>
            <p class="col-12 h4">Jadwal Pemeliharaan <button class="btn btn-outline-primary" onclick="showModalAddJadwalPemeliharaan()" data-toggle="tooltip" data-placement="top" title="Tambah Jadwal"><i class="fa-regular fa-plus"></i></button></p>
            {{-- <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="showModalAddJadwalPemeliharaan()"><i class="fa-regular fa-clock"></i> + Jadwal</button>
            </div> --}}
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="tableJadwalPemeliharaan">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Tugas</th>
                        <th>Frekuensi</th>
                        <th>Periode Sebelumnya</th>
                        <th>Periode Berikutnya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <hr class="my-4" />

        <div class="row align-items-center mt-3">
            <p class="col-8 h4">Daftar Pemeliharaan Preventif</p>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="tablePemeliharaanPreventif">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Tanggal Mulai</th>
                        <th>Petugas</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="row align-items-center mt-3">
            <p class="col-12 h4">Daftar Pemeliharaan Korektif <button class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Tambah Pemeliharaan Korektif" onclick="showModalPemeliharaanKorektif()"><i class="fa-solid fa-plus"></i></button></p>
            {{-- <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="showModalPemeliharaanKorektif()"><i class="fa-solid fa-screwdriver-wrench"></i> + Pemeliharaan</button>
            </div> --}}
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="tablePemeliharaanKorektif">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Tanggal Mulai</th>
                        <th>Petugas</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        @include('admin.modals.add-jadwal-preventif')
        @include('admin.modals.edit-jadwal-preventif')
        @include('admin.modals.add-preventif')


    </div>
@endsection

@push('script-foot')
    <script>
        // Handle Tabel
        $(document).ready(function() {
            tableJadwalPemeliharaan();
        });
        $(document).ready(function() {
            tablePemeliharaanPreventif();
        });
        $(document).ready(function() {
            tablePemeliharaanKorektif();
        });

        function tableJadwalPemeliharaan() {
            $('#tableJadwalPemeliharaan').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.asetrt.pemeliharaan.scheduleDataTable', $id) }}",
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
                                "4": "<i class='fa-regular fa-bell'></i> 4 bulan sekali",
                                "6": "<i class='fa-regular fa-bell'></i> 6 bulan sekali",
                                "12": "<i class='fa-regular fa-bell'></i> 12 bulan sekali",
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
                        url: "{{ route('admin.asetrt.pemeliharaan.scheduleDelete', ['id' => ':id']) }}".replace(':id', id),
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

        function tablePemeliharaanKorektif() {
            $('#tablePemeliharaanKorektif').DataTable({
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
@endpush
