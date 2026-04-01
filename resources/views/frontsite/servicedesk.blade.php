@extends('layouts.front', ['title' => 'Service Desk - SAPA PPL'])

@push('script-head')
    @stack('script-head')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero-custom section dark-background">
            {{-- <div class="container"> --}}
            {{-- </div> --}}
        </section><!-- End Hero Section -->

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container">
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="">Layanan</li>
                        <li class="current">Service Desk</li>
                    </ol>
                </nav>
                {{-- <h1>Layanan</h1> --}}
            </div>
        </div><!-- End Page Title -->

        <!-- Services Section -->
        <section id="" class="">
            <div class="container">
                <h2>Service Desk berbasis Tiket</h2>
                <p>Fitur Service Desk Sarana & Prasarana berbasis Tiket digunakan untuk mengelola permintaan layanan sarana dan prasarana yang diajukan oleh pengguna. Dengan fitur ini, pengguna dapat mengajukan tiket permintaan layanan, melacak status tiket, dan
                    berkomunikasi dengan tim layanan untuk memastikan permintaan mereka ditangani dengan efisien dan tepat waktu.</p>
            </div><!-- End Section Title -->



            <div class="container">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">Tiket Service Desk</h5>
                        <button class="btn btn-outline-primary" onclick="openModalCreate()" style="margin-left: auto;" data-toggle="tooltip" data-placement="top" title="Buat Tiket"><i class="fa-regular fa-plus"></i> Buat Tiket</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablePemeliharaan" class="table table-bordered table-striped table-hover table-sm table-responsive-md">
                                <thead>
                                    <tr>
                                        <th>Tiket</th>
                                        <th>Pemohon</th>
                                        <th>Jenis & Bidang</th>
                                        <th>Judul</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">Prioritas</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tanggal</th>
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

            @include('frontsite.partials.createtiket')
        </section><!-- /Services Section -->
    </main><!-- End #main -->


    @push('script-foot')
        <script>
            $(document).ready(function() {
                tablePemeliharaan();
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
                            data: 'pemohon',
                            name: 'pemohon'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            render: function(data, type, row) {
                                let html = '';
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
        </script>
    @endpush
@endsection
