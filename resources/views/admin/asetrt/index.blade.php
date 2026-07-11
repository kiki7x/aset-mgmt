@extends('layouts.backsite', [
    'title' => 'Aset Rumah Tangga | SAPA PPL',
    'welcome' => 'Aset Rumah Tangga',
    'breadcrumb' => '
        <li class="breadcrumb-item active">Aset RT</li>',
])

@push('script-head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    {{-- DataTable Css --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex bd-highlight">
            <h3 class="card-title font-weight-bold mr-auto p-2 bd-highlight"><i class="fa-solid fa-building"></i> Aset Rumah Tangga <span class="badge end-0 mr-3 bg-info text-light">{{ $totalAssets }}</span></h3>
            <div>
                <button type="button" id="btnOpenCreateModal" class="btn btn-outline-primary bd-highlight" data-toggle="tooltip" data-placement="top" title="Tambah Data" data-crud="true">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row g-2 mb-3 align-items-end">
                <div class="col-12 col-md-3">
                    <label for="category" class="form-label mb-1">Filter Kategori</label>
                    <select id="category" name="jenis" class="ml-0 form-control mr-2">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm" id="tableAsetrt">
                    <thead>
                        <tr>
                            <th>Tag</th>
                            <th>Nama Aset</th>
                            <th>Kategori</th>
                            <th>Tipe/Model</th>
                            <th>Foto</th>
                            <th>Tanggal</th>
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

        @include('admin.asetrt.partials.create-modal')
        @include('admin.asetrt.partials.delete-modal')
        @include('admin.asetrt.partials.qrcode-modal')
        </section>

        @push('script-foot')
            <!-- InputMask -->
            <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
            {{-- Select2 --}}
            <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

            {{-- TableScript --}}
            <script>
                function initTableAsetrt() {
                    $('#tableAsetrt').DataTable({
                        layout: {
                            topEnd: {
                                search: {
                                    placeholder: 'nama / serial no'
                                }
                            }
                        },
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: {
                            url: "{{ route('admin.asetrt.get_assets') }}",
                            data: function(d) {
                                d.category = $('#category').val();
                                d.classification =
                                    'rt';
                            }
                        },
                        language: {
                            emptyTable: 'Tidak ada data.',
                            processing: 'Memuat...',
                            search: 'Cari:',
                            lengthMenu: 'Tampilkan _MENU_ baris',
                            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                            infoEmpty: 'Menampilkan 0 sampai 0 dari 0 entri',
                            paginate: {
                                previous: 'Sebelumnya',
                                next: 'Berikutnya'
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
                                data: null,
                                name: 'image',
                                render: function(data) {
                                    if (data.image && data.image !== '-') {
                                        return `<img src="{{ asset('storage') }}/${data.image}" alt="Foto Aset" class="img-fluid" style="max-width: 100px;"/>`;
                                    }
                                    return '-';
                                },
                            },
                            {
                                data: null,
                                name: 'timestamp',
                                render: function(data) {
                                    return `
                                    <small class="text-muted">Dibuat: ${moment(data.created_at).format('DD MMM YYYY HH:mm')}</small><br>
                                    <small class="text-muted">Diperbarui: ${moment(data.updated_at).format('DD MMM YYYY HH:mm')}</small>
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
                    $('#tableAsetrt').DataTable().ajax.reload();
                });

                $(document).ready(function() {
                    initTableAsetrt();
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
            </script>

        @endpush
    @endsection
