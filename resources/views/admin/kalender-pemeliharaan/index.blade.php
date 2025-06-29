@extends('layouts.backsite', [
    'title' => 'Kalender Pemeliharaan | SAPA PPL',
    'welcome' => 'Kalender Pemeliharaan',
    'breadcrumb' => '
        <li class="breadcrumb-item active">Kalender Pemeliharaan</li>'
])

@push('script-head')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 class="card-title">Kalender Pemeliharaan</h3>
                        <button type="button" class="btn btn-primary" style="margin-left: auto;">
                            <i class="fas fa-square-plus"></i>
                            Tambah Jadwal Pemeliharaan
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tableKalenderPemeliharaan" class="table table-bordered table-striped table-responsive-md">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Frekuensi</th>
                                        <th>Jadwal Mulai</th>
                                        <th>Jadwal Berikutnya</th>
                                        <th>Status</th>
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
@endsection

