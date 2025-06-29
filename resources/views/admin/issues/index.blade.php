@extends('layouts.backsite', [
    'title' => 'Penugasan | SAPA PPL',
    'welcome' => 'Penugasan',
    'breadcrumb' => '
        <li class="breadcrumb-item active">Penugasan</li>'
])

@push('script-head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    {{-- DataTable Css --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 class="card-title">Kelola Penugasan</h3>
                        <button type="button" class="btn btn-primary" style="margin-left: auto;">
                            <i class="fas fa-square-plus"></i>
                            Buat Penugasan
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">

                            <table id="tablePenugasan" class="table table-bordered table-striped table-responsive-md">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Petugas</th>
                                        <th>Entitas Terkait</th>
                                        <th>Status</th>
                                        <th>Tenggat Waktu</th>
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
                                            <span aria-hidden="true">×</span>
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
        </div>
    </div>

    {{-- Komponen Modal/CreateAsetTik --}}
    {{-- @livewire('modal.create-issue') --}}
@endsection

@push('script-foot')
    <script>
        $(document).ready(function() {
            tablePenugasan();
        });

        function tablePenugasan() {
            $('#tablePenugasan').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.issues.get_issues') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'pic_id',
                        name: 'pic_id'
                    },
                    {
                        data: 'asset_id',
                        name: 'asset_id',
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'duedate',
                        name: 'duedate'
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
