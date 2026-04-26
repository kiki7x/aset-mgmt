@extends('layouts.backsite', [
    'title' => 'Import | SAPA PPL',
    'welcome' => 'Import Data',
    'breadcrumb' => '
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Import</li>
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
                {{-- Import Aset Rumah Tangga --}}
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-building"></i> Import Aset Rumah Tangga <span class="badge end-0 mr-3 bg-info text-light"></span></h3>
                        </div>
                        <form id="formImportAsetRt" method="POST" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-auto">
                                        <div class="form-group">
                                            <label for="attachment">Import Aset Rumah Tangga <span class="text-danger">*</span></label>
                                            <div class="custom-file">
                                                <input type="file" class="form-control custom-file-input" id="importasetrt" name="attachment" accept=".xlsx" required>
                                                <label class="custom-file-label" for="attachment">Import Aset Rumah Tangga</label>
                                                <small class="form-text text-muted">Format: XLSX (Max: 2MB)</small>
                                            </div>
                                            <span id="error-attachment" class="text-danger small"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <a href="javascript:void(0)" id="btnTemplateAsetRt" class="btn btn-secondary mr-2">
                                    <i class="fas fa-file-download"></i> Download Template
                                </a>
                                <button type="submit" id="btnImportAsetRt" class="btn btn-primary">
                                    <i class="fas fa-file-import"></i> Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr>

            {{-- Import Aset TIK --}}
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-computer"></i> Import Aset TIK <span class="badge end-0 mr-3 bg-info text-light"></span></h3>
                        </div>
                        <form id="formImportAsetTik" method="POST" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-auto">
                                        <div class="form-group">
                                            <label for="fileasettik">Import Aset TIK <span class="text-danger">*</span></label>
                                            <div class="custom-file">
                                                <input type="file" class="form-control custom-file-input" id="fileasettik" name="fileasettik" accept=".xlsx" required>
                                                <label class="custom-file-label" for="fileasettik">Import Aset TIK</label>
                                                <small class="form-text text-muted">Format: XLSX (Max: 2MB)</small>
                                            </div>
                                            <span id="error-fileasettik" class="text-danger small"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <a href="javascript:void(0)" id="btnTemplateAsetTik" class="btn btn-secondary mr-2">
                                    <i class="fas fa-file-download"></i> Download Template
                                </a>
                                <button type="submit" id="btnImportAsetTik" class="btn btn-primary">
                                    <i class="fas fa-file-import"></i> Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Import Komponen TIK --}}
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-mouse"></i> Import Komponen TIK <span class="badge end-0 mr-3 bg-info text-light"></span></h3>
                        </div>
                        <form id="formImportKomponentTik" method="POST" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-auto">
                                        <div class="form-group">
                                            <label for="filekomponentik">Import Komponen TIK <span class="text-danger">*</span></label>
                                            <div class="custom-file">
                                                <input type="file" class="form-control custom-file-input" id="filekomponentik" name="filekomponentik" accept=".xlsx" required>
                                                <label class="custom-file-label" for="filekomponentik">Import Komponen TIK</label>
                                                <small class="form-text text-muted">Format: XLSX (Max: 2MB)</small>
                                            </div>
                                            <span id="error-filekomponentik" class="text-danger small"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <a href="javascript:void(0)" id="btnTemplateKomponenTik" class="btn btn-secondary mr-2">
                                    <i class="fas fa-file-download"></i> Download Template
                                </a>
                                <button type="submit" id="btnImportKomponenTik" class="btn btn-primary">
                                    <i class="fas fa-file-import"></i> Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- Import Lisensi TIK --}}
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-key"></i> Import Lisensi TIK <span class="badge end-0 mr-3 bg-info text-light"></span></h3>
                        </div>
                        <form id="formImportLisensitTik" method="POST" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-auto">
                                        <div class="form-group">
                                            <label for="attachment">Import Lisensi TIK <span class="text-danger">*</span></label>
                                            <div class="custom-file">
                                                <input type="file" class="form-control custom-file-input" id="importlisensitik" name="attachment" accept=".xlsx" required>
                                                <label class="custom-file-label" for="attachment">Import Lisensi TIK</label>
                                                <small class="form-text text-muted">Format: XLSX (Max: 2MB)</small>
                                            </div>
                                            <span id="error-attachment" class="text-danger small"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <a href="javascript:void(0)" id="btnTemplateLisensiTik" class="btn btn-secondary mr-2">
                                    <i class="fas fa-file-download"></i> Download Template
                                </a>
                                <button type="submit" id="btnImportLisensiTik" class="btn btn-primary">
                                    <i class="fas fa-file-import"></i> Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr>

            {{-- Import Lokasi --}}
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 class="card-title font-weight-bold"><i class="fa-regular fa-building"></i> Import Lokasi Ruangan <span class="badge end-0 mr-3 bg-info text-light"></span></h3>
                        </div>
                        <form id="formImportLokasi" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-auto">
                                        <div class="form-group">
                                            <label for="filelokasi">Import Lokasi Ruangan <span class="text-danger">*</span></label>
                                            <div class="custom-file">
                                                <input type="file" class="form-control custom-file-input" id="filelokasi" name="filelokasi" accept=".xlsx" required>
                                                <label class="custom-file-label" for="attachment">Import Lokasi Ruangan</label>
                                                <small class="form-text text-muted">Format: XLSX (Max: 2MB)</small>
                                            </div>
                                            <span id="error-filelokasi" class="text-danger small"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <a href="javascript:void(0)" id="btnTemplateLokasi" class="btn btn-secondary mr-2">
                                    <i class="fas fa-file-download"></i> Download Template
                                </a>
                                <button type="submit" id="btnImportLokasi" class="btn btn-primary">
                                    <i class="fas fa-file-import"></i> Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @push('script-foot')
        <script>
            $(function() {
                bsCustomFileInput.init();
            });
        </script>

        <script>
            $('#formImportLokasi').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('filelokasi', $('#filelokasi')[0].files[0]);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.settings.import.storelokasi') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#btnImportLokasi').addClass('disabled').attr('disabled', true);
                        $('#btnImportLokasi').html('<i class="fa fa-spinner fa-spin"></i> Mengunggah Data...');
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data Lokasi berhasil disimpan!',
                        }).then(() => {
                            $('#formImportLokasi')[0].reset(); // Reset form fields
                            $('#btnImportLokasi').removeClass('disabled').attr('disabled', false);
                            $('#btnImportLokasi').html('<i class="fas fa-file-import"></i> Import');
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan. Periksa kembali data unggahan.',
                        })
                    }
                });
            });
        </script>

        <script>
            $('#formImportAsetTik').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('fileasettik', $('#fileasettik')[0].files[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.settings.import.storeasettik') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#btnImportAsetTik').addClass('disabled').attr('disabled', true);
                        $('#btnImportAsetTik').html('<i class="fa fa-spinner fa-spin"></i> Mengunggah Data...');
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Semua data (' + res.success_count + ') berhasil disimpan!',
                        }).then(() => {
                            $('#formImportAsetTik')[0].reset(); // Reset form fields
                            $('#btnImportAsetTik').removeClass('disabled').attr('disabled', false);
                            $('#btnImportAsetTik').html('<i class="fas fa-file-import"></i> Import');
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            // text: 'Terjadi kesalahan. Periksa kembali data unggahan.',
                            text: res.errors.forEach(function(err) {
                                errorHtml += '<li>' + err + '</li>' + '<br>'
                            }),
                        });
                    },
                });
            });
        </script>
    @endpush
@endsection
