@extends('layouts.backsite', [
    'title' => 'Aset TIK | SAPA PPL',
    'welcome' => 'Aset TIK',
    'breadcrumb' => '
        <li class="breadcrumb-item active">Aset TIK</li>',
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
                        <div class="card-header d-flex bd-highlight">
                            <h3 class="card-title font-weight-bold mr-auto p-2 bd-highlight"><i class="fa-solid fa-computer"></i> Aset TIK <span class="badge end-0 mr-3 bg-info text-light">{{ $totalAssets }}</span></h3>
                            {{-- buat 2 tombol rata kanan --}}
                            <a href="javascript:void(0)" id="btnExport" class="btn btn-outline-primary bd-highlight" data-toggle="tooltip" data-placement="top" title="Export">
                                <i class="fas fa-file-arrow-down"></i> Export
                            </a>
                            <button type="button" id="btnOpenCreateModal" class="btn btn-outline-primary bd-highlight" data-toggle="tooltip" data-placement="top" title="Tambah Data">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 mt-auto">
                                    <div class="px-2 d-flex">
                                        <select id="category" name="jenis" class="ml-0 form-control mr-2">
                                            <option value="">Semua Kategori</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="ml-0 btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Filter"><i class="fas fa-filter"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="tableAsettik" class="table table-bordered table-striped table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tag</th>
                                            <th>Nama Aset</th>
                                            <th>Kategori</th>
                                            <th>Tipe/Model</th>
                                            <th>Pengguna</th>
                                            <th>Timestamp</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div class="dt-buttons btn-group"><a class="btn btn-default buttons-copy buttons-html5"
                                            tabindex="0" aria-controls="dataTablesFull"
                                            href="#"><span>Copy</span></a><a
                                            class="btn btn-default buttons-csv buttons-html5" tabindex="0"
                                            aria-controls="dataTablesFull" href="#"><span>CSV</span></a><a
                                            class="btn btn-default buttons-excel buttons-html5" tabindex="0"
                                            aria-controls="dataTablesFull" href="#"><span>Excel</span></a><a
                                            class="btn btn-default buttons-pdf buttons-html5" tabindex="0"
                                            aria-controls="dataTablesFull" href="#"><span>PDF</span></a><a
                                            class="btn btn-default buttons-print" tabindex="0"
                                            aria-controls="dataTablesFull" href="#"><span>Print</span></a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Komponen Modal --}}
        @include('admin.asettik.partials.create-modal')
        @include('admin.asettik.partials.delete-modal')
        @include('admin.asettik.partials.qrcode-modal')
    </section>

    @push('script-foot')
        <!-- InputMask -->
        <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
        {{-- Select2 --}}
        <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

        {{-- TableScript --}}
        <script>
            function initTableAsettik() {
                $('#tableAsettik').DataTable({
                    layout: {
                        topEnd: {
                            search: {
                                placeholder: 'nama aset / serial no'
                            }
                        }
                    },
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('admin.asettik.get_assets') }}",
                        data: function(d) {
                            d.category = $('#category').val();
                            d.classification =
                                'tik';
                        }
                    },
                    columns: [{
                            data: 'tag',
                            name: 'tag'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'category',
                            name: 'category'
                        },
                        {
                            data: 'model',
                            name: 'model'
                        },
                        {
                            data: 'user',
                            name: 'user'
                        },
                        {
                            data: null,
                            name: 'timestamp',
                            render: function(data) {
                                return `
                                    Tahun Perolehan: ${data.purchase_date ? moment(data.purchase_date).format('YYYY') : '-'} <br>
                                    <span class="text-muted small">Dibuat: ${moment(data.created_at).format('lll')} <br>
                                    Diupdate: ${moment(data.updated_at).format('lll')} </span><br>
                                    `;
                            }
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

            $('#category').on('change', function() {
                $('#tableAsettik').DataTable().ajax.reload();
            });

            $(document).ready(function() {
                initTableAsettik();
            })
        </script>

        {{-- ModalManagement --}}
        <script>
            $(document).ready(function() {
                // Create Modal
                $('#btnOpenCreateModal').on('click', function() {
                    $('#createModal').modal('show');
                });

                // Delete Modal
                $('#deleteModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var name = button.data('name');

                    var modal = $(this)
                    modal.find('#assetName').text(name)
                });

                // QR Code Modal
                $('#qrCodeModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var name = button.data('name');
                    var modal = $(this)
                });
            });

            // buat fungsi export
            // $('#btnExport').on('click', function(e) {
            //     e.preventDefault();
            //     // alert('export');

            //     // Opsional: Beri loading state pada tombol
            //     const originalText = $(this).html();
            //     $(this).html('<i class="fa fa-spinner fa-spin"></i> Menyiapkan Data...').addClass('disabled');

            //     window.location.href = "{{ route('admin.asettik.export') }}";
            //     // Kembalikan tombol setelah beberapa detik
            //     setTimeout(() => {
            //         $(this).html(originalText).removeClass('disabled');
            //     }, 5000);
            // });

            //buat fungsi export dengan gaya sweetalert
            $('#btnExport').on('click', function(e) {
                e.preventDefault();
                // alert('export');

                // Opsional: Beri loading state pada tombol
                const originalText = $(this).html();
                $(this).html('<i class="fa fa-spinner fa-spin"></i> Menyiapkan Data...').addClass('disabled');

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'info',
                    title: 'Menyiapkan Data...'
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = "{{ route('admin.asettik.export') }}";
                    }
                    // Kembalikan tombol setelah beberapa detik
                    setTimeout(() => {
                        $(this).html(originalText).removeClass('disabled');
                    });
                });
            })
        </script>
    @endpush
@endsection
