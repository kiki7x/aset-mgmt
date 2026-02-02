@extends('layouts.backsite', [
    'title' => 'Pemeliharaan Korektif | SAPA PPL',
    'welcome' => 'Pemeliharaan Korektif',
    'breadcrumb' => '
        <li class="breadcrumb-item active">Pemeliharaan Korektif</li>',
])

@push('script-head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    {{-- DataTable Css --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
@endpush

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-list-check"></i> Pemeliharaan Korektif <span class="badge end-0 mr-3 bg-info text-light">{{ $totalPemeliharaan }} </span></h3>
                            <button class="btn btn-outline-primary" onclick="openModalCreate()" style="margin-left: auto;" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa-regular fa-plus"></i></button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tablePemeliharaan" class="table table-bordered table-striped table-hover table-sm table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Petugas</th>
                                            <th>Aset Terkait</th>
                                            <th class="text-center">Prioritas</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Tenggat Waktu</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!-- Modal Konfirmasi -->
                            <div class="modal fade" data-backdrop="static" role="dialog" id="modalDelete">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Penghapusan !</h5>
                                            <button type="button" class="close" aria-label="Close">
                                                <span>×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus data ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button wire:click="$dispatch('closeModalDelete')" type="button" class="btn btn-secondary">Batal</button>
                                            <button wire:click="$dispatch('delete', { id:  })" type="button" class="btn btn-danger">Ya, Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Pagination -->
                                <div class="col-md-12">

                                </div>
                                <div class="col-md-12">
                                    <div class="dt-buttons btn-group"><a class="btn btn-default buttons-copy buttons-html5" tabindex="0" aria-controls="dataTablesFull" href="#"><span>Copy</span></a><a class="btn btn-default buttons-csv buttons-html5"
                                           tabindex="0" aria-controls="dataTablesFull" href="#"><span>CSV</span></a><a class="btn btn-default buttons-excel buttons-html5" tabindex="0" aria-controls="dataTablesFull" href="#"><span>Excel</span></a><a
                                           class="btn btn-default buttons-pdf buttons-html5" tabindex="0" aria-controls="dataTablesFull" href="#"><span>PDF</span></a><a class="btn btn-default buttons-print" tabindex="0" aria-controls="dataTablesFull"
                                           href="#"><span>Print</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-list-check"></i> Pemeliharaan Korektif Selesai <span class="badge end-0 mr-3 bg-info text-light"> {{ $totalPemeliharaanSelesai }} </span></h3>
                            {{-- <button class="btn btn-outline-primary" onclick="openModalCreate()" style="margin-left: auto;" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa-regular fa-plus"></i></button> --}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- <div class="table-responsive"> --}}
                            <table id="tablePemeliharaanSelesai" class="table table-bordered table-striped table-hover table-sm table-responsive-md">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Judul</th>
                                        <th>Aset Terkait</th>
                                        <th>Petugas</th>
                                        <th>Catatan</th>
                                        <th>Diselesaikan Pada</th>
                                        <th>Bukti Dukung</th>
                                        <th>Biaya</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            {{-- </div> --}}
                            <!-- Modal Konfirmasi -->
                            <div class="modal fade" data-backdrop="static" role="dialog" id="modalDelete">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Penghapusan !</h5>
                                            <button type="button" class="close" aria-label="Close">
                                                <span>×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus data ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button wire:click="$dispatch('closeModalDelete')" type="button" class="btn btn-secondary">Batal</button>
                                            <button wire:click="$dispatch('delete', { id:  })" type="button" class="btn btn-danger">Ya, Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Pagination -->
                                <div class="col-md-12">

                                </div>
                                <div class="col-md-12">
                                    <div class="dt-buttons btn-group"><a class="btn btn-default buttons-copy buttons-html5" tabindex="0" aria-controls="dataTablesFull" href="#"><span>Copy</span></a><a class="btn btn-default buttons-csv buttons-html5"
                                           tabindex="0" aria-controls="dataTablesFull" href="#"><span>CSV</span></a><a class="btn btn-default buttons-excel buttons-html5" tabindex="0" aria-controls="dataTablesFull"
                                           href="#"><span>Excel</span></a><a class="btn btn-default buttons-pdf buttons-html5" tabindex="0" aria-controls="dataTablesFull" href="#"><span>PDF</span></a><a class="btn btn-default buttons-print"
                                           tabindex="0" aria-controls="dataTablesFull" href="#"><span>Print</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Komponen Modal/CreateAsetTik --}}
        @include('admin.pemeliharaan-korektif.partials.create-pemeliharaan')
        @include('admin.pemeliharaan-korektif.partials.tl-pemeliharaan')
        @include('admin.pemeliharaan-korektif.partials.edit-pemeliharaan')
    </section>

    @push('script-foot')
        <!-- InputMask -->
        <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
        {{-- Select2 --}}
        <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                tablePemeliharaan();
            });

            $(document).ready(function() {
                tablePemeliharaanSelesai();
            });

            function tablePemeliharaan() {
                $('#tablePemeliharaan').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('admin.pemeliharaan.pemeliharaanDataTable') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            render: function(data, type, row) {
                                let html = '';
                                // if (row.priority == "Rendah") html += "<i class='fa fa-flag fa-fw text-info' data-toggle='tooltip' title='Rendah'></i>&nbsp;";
                                // if (row.priority == "Sedang") html += "<i class='fa fa-flag fa-fw text-warning' data-toggle='tooltip' title='Sedang'></i>&nbsp;";
                                // if (row.priority == "Tinggi") html += "<i class='fa fa-flag fa-fw text-danger' data-toggle='tooltip' title='Tinggi'></i>&nbsp;";

                                if (row.issuetype == "Tugas") html += "<i class='fa-regular fa-square-check fa-fw text-info' data-toggle='tooltip' title='Tugas'></i>&nbsp;";
                                if (row.issuetype == "Perbaikan") html += "<i class='fa-solid fa-screwdriver-wrench fa-fw text-warning' data-toggle='tooltip' title='Perbaikan'></i>&nbsp;";
                                if (row.issuetype == "Peningkatan") html += "<i class='fa-solid fa-arrow-up-right-dots fa-fw text-teal' data-toggle='tooltip' title='Peningkatan'></i>&nbsp;";
                                if (row.issuetype == "Celah") html += "<i class='fa-solid fa-bug fa-fw text-danger' data-toggle='tooltip' title='Celah'></i>&nbsp;";
                                if (row.issuetype == "Fitur Baru") html += "<i class='fa-regular fa-plus-square fa-fw text-success' data-toggle='tooltip' title='Fitur Baru'></i>&nbsp;";
                                if (row.issuetype == "Informasi") html += "<i class='fa-solid fa-circle-info text-danger' data-toggle='tooltip' title='Informasi'></i>&nbsp;";

                                return html + row.name;
                            }
                        },
                        {
                            data: 'description',
                            name: 'description',
                            render: function(data, type, row) {
                                return data;
                            }
                        },
                        {
                            data: 'pic',
                            name: 'pic',
                            render: function(data, type, row) {
                                let html = '';
                                if (row.pic.avatar != null) {
                                    html += "<img src='" + row.pic.avatar + "' alt='Avatar' class='img-circle' width='25' height='25'>&nbsp;";
                                } else {
                                    html += "<img src='{{ asset('storage/avatar/default-avatar.jpg') }}' alt='Avatar' class='img-circle' width='25' height='25'>&nbsp;";
                                }
                                return html + row.pic;
                            }
                        },
                        {
                            data: 'asset',
                            name: 'asset',
                            render: function(data, type, row) {
                                return '<a href="/admin/asettik/' + row.asset_id + '/overview" target="_blank">' + row.asset.tag + ' - ' + row.asset.name + '</a>';
                            }
                        },
                        {
                            data: 'priority',
                            name: 'priority',
                            render: function(data, type, row) {
                                let priorityBadge = '';
                                if (data === 'Tinggi') {
                                    priorityBadge = '<span class="badge" style="border:1px solid #dc3545; color:#dc3545;"><i class="fa fa-flag fa-fw text-danger" data-toggle="tooltip" title="Tinggi"></i>&nbsp;Tinggi</span>';
                                } else if (data === 'Sedang') {
                                    priorityBadge = '<span class="badge" style="border:1px solid #ffc107; color:#ffc107;"><i class="fa fa-flag fa-fw text-warning" data-toggle="tooltip" title="Sedang"></i>&nbsp;Sedang</span>';
                                } else if (data === 'Rendah') {
                                    priorityBadge = '<span class="badge" style="border:1px solid #6c757d; color:#6c757d;"><i class="fa fa-flag fa-fw text-secondary" data-toggle="tooltip" title="Rendah"></i>&nbsp;Rendah</span>';
                                } else {
                                    priorityBadge = '<span class="badge badge-secondary">' + data + '</span>';
                                }
                                return '<div style="text-align: center;">' + priorityBadge + '</div>';
                            }
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                let statusBadge = '';
                                if (data === 'Segera Kerjakan') {
                                    statusBadge = '<span class="badge badge-danger">Segera Kerjakan</span>';
                                } else if (data === 'Sedang Dikerjakan') {
                                    statusBadge = '<span class="badge badge-warning">Sedang Dikerjakan</span>';
                                } else if (data === 'Ditahan') {
                                    statusBadge = '<span class="badge badge-secondary">Ditahan</span>' + (row.notes ? ' <br> <span class="text-muted">alasan tertahan: ' + row.notes : '</span>');
                                } else if (data === 'Selesai') {
                                    statusBadge = '<span class="badge badge-success">Selesai</span>';
                                } else {
                                    statusBadge = '<span class="badge badge-secondary">' + data + '</span>';
                                }
                                return '<div style="text-align: center;">' + statusBadge + '</div>';
                            }
                        },
                        {
                            data: 'duedate',
                            name: 'duedate',
                            render: function(data, type, row) {
                                return '<div style="text-align: center;">' + data + '</div>';
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                })
            };

            function tablePemeliharaanSelesai() {
                $('#tablePemeliharaanSelesai').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('admin.pemeliharaan.pemeliharaanDataTableSelesai') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            render: function(data, type, row) {
                                let html = '';
                                if (row.priority == "High") html += "<i class='fa fa-flag fa-fw text-danger' data-toggle='tooltip' title='High priority'></i>&nbsp;";
                                if (row.priority == "Medium") html += "<i class='fa fa-flag fa-fw text-warning' data-toggle='tooltip' title='Medium priority'></i>&nbsp;";
                                if (row.priority == "Low") html += "<i class='fa fa-flag fa-fw text-info' data-toggle='tooltip' title='Low priority'></i>&nbsp;";

                                if (row.type == "Tugas") html += "<i class='fa fa-check-square fa-fw text-info' data-toggle='tooltip' title='Task'></i>&nbsp;";
                                if (row.type == "Perbaikan") html += "<i class='fa fa-minus-square fa-fw text-warning' data-toggle='tooltip' title='Maintenance'></i>&nbsp;";
                                if (row.type == "Celah") html += "<i class='fa fa-bug fa-fw text-danger' data-toggle='tooltip' title='Bug'></i>&nbsp;";
                                if (row.type == "Peningkatan") html += "<i class='fa fa-external-link fa-fw text-teal' data-toggle='tooltip' title='Improvement'></i>&nbsp;";
                                if (row.type == "Fitur Baru") html += "<i class='fa fa-plus-square fa-fw text-success' data-toggle='tooltip' title='New Feature'></i>&nbsp;";
                                if (row.type == "Informasi") html += "<i class='fa fa-circle fa-fw text-danger' data-toggle='tooltip' title='Story'></i>&nbsp;";

                                return html + row.name;
                            }
                        },
                        {
                            data: 'asset',
                            name: 'asset',
                            render: function(data, type, row) {
                                if (row.asset.classification_id == 2) {
                                    return '<a href="/admin/asettik/' + row.asset_id + '/overview" target="_blank">' + row.asset.tag + ' - ' + row.asset.name + '</a>';;
                                } else {
                                    return '<a href="/admin/asetrt/' + row.asset_id + '/overview" target="_blank">' + row.asset.tag + ' - ' + row.asset.name + '</a>';
                                }
                                // return '<a href="/admin/asettik/' + row.asset_id + '/overview" target="_blank">' + row.asset.tag + ' - ' + row.asset.name + '</a>';
                            }
                        },
                        {
                            data: 'pic',
                            name: 'pic',
                            render: function(data, type, row) {
                                let html = '';
                                if (row.pic.avatar != null) {
                                    html += "<img src='" + row.pic.avatar + "' alt='Avatar' class='img-circle' width='25' height='25'>&nbsp;";
                                } else {
                                    html += "<img src='{{ asset('storage/avatar/default-avatar.jpg') }}' alt='Avatar' class='img-circle' width='25' height='25'>&nbsp;";
                                }
                                return html + row.pic;
                            }
                        },
                        {
                            data: 'notes',
                            name: 'notes'
                        },
                        {
                            data: 'completed_at',
                            name: 'completed_at'
                        },
                        {
                            data: 'attachment',
                            name: 'attachment',
                            render: function(data, type, row) {
                                if (data) {
                                    return `<a href="{{ asset('storage') }}/${data}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-file-arrow-down"></i> Unduh</a>`;
                                } else {
                                    return 'Tidak ada bukti dukung';
                                }
                            }
                        },
                        {
                            data: 'cost',
                            name: 'cost',
                            render: function(data, type, row) {
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    maximumFractionDigits: 0
                                }).format(data);
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                })
            };
        </script>
    @endpush
@endsection
