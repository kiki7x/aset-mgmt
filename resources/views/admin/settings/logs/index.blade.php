@extends('layouts.backsite', [
    'title' => 'Logs | SAPA PPL',
    'welcome' => 'Logs',
    'breadcrumb' => '
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Logs</li>
    ',
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
                            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-clock-rotate-left"></i> Logs <span class="badge end-0 mr-3 bg-info text-light"></span></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 mt-auto">
                                    <div class="px-2 d-flex">
                                        {{-- Tampilkan data Logs di sini --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @push('script-foot')
        <script></script>

        <script></script>
    @endpush
@endsection
