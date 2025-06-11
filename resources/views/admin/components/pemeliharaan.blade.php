@extends('layouts.backsite-navtab-asetrt')

@push('script-head')
@stack('script-head')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content-tab')
    <div class="container-fluid">
        <div class="row align-items-center">
            <p class="col-12 h4 d-flex justify-content-center text-info">{{ $assets->tag }} - {{ $assets->name }}</p>
            <p class="col-8 h4">Jadwal Pemeliharaan</p>
            <div class="col d-flex justify-content-end">
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalJadwalPemeliharaan" onclick="showModalCreate()"><i class="fa-regular fa-clock"></i> + Jadwal</button> --}}
                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="showModalJadwalPemeliharaan()" ><i class="fa-regular fa-clock"></i> + Jadwal</button>
            </div>
            {{-- <div class="col d-flex justify-content-start">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalKorektif"><i class="fa-solid fa-screwdriver-wrench"></i> Korektif</button>
            </div> --}}
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="tableJadwalPemeliharaan">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Frekuensi</th>
                        <th>Tanggal Mulai</th>
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
            <table class="table table-bordered table-striped table-hover" id="tablePemeliharaan">
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

        @include('admin.modals.preventif_rt_modal')
        {{-- @include('admin.modals.korektif_rt_modal') --}}


    </div>
@endsection

@push('script-foot')
    <script>
        $('#start_date').datepicker({
            changeMonth: true,
            changeYear: true,
            // format: "dd/mm/yyyy"
            format: "yyyy/mm/dd"
        });
    </script>

    <script>
        function showModalJadwalPemeliharaan() {
            $('#modalJadwalPemeliharaan').modal('show');
            // $('#modalJadwalPemeliharaanLabel').text('Jadwalkan Pemeliharaan Preventif');
            // $('#submitJadwalPemeliharaan').text('Jadwalkan');
        }

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
                        name: 'frequency'
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

    <script>
        function showModalPemeliharaan() {
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
@stack('script-foot')
@endpush
