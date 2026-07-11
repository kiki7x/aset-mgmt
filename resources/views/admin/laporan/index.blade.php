@extends('layouts.backsite', [
    'title' => 'Laporan | SAPA PPL',
    'welcome' => 'Laporan',
    'breadcrumb' => '<li class="breadcrumb-item active">Laporan</li>',
])

@push('script-head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    {{-- DataTable Css --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <div class="row">
        {{-- Aset TIK --}}
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card collapsed-card" data-card-widget="collapse">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-computer mr-1"></i> Aset TIK</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body py-2">
                    <form class="form-laporan" data-type="aset-tik">
                        @csrf
                        <div class="form-group">
                            <label class="mb-n1 small">Klasifikasi</label>
                            <select name="klasifikasi[]" class="form-control form-control-sm select2-multi" multiple data-placeholder="Pilih...">
                                @foreach ($klasifikasi->whereIn('id', [2]) as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-n1 small">Kategori</label>
                            <select name="kategori[]" class="form-control form-control-sm select2-multi" multiple data-placeholder="Pilih...">
                                @foreach ($kategoriAset->whereIn('classification_id', [2]) as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-n1 small">Tahun</label>
                                    <select name="tahun" class="form-control form-control-sm">
                                        <option value="">Semua</option>
                                        @for ($y = date('Y'); $y >= date('Y') - 10; $y--)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-n1 small">Bulan</label>
                                    <select name="bulan" class="form-control form-control-sm">
                                        <option value="">Semua</option>
                                        @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $i => $b)
                                            <option value="{{ $i + 1 }}">{{ $b }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm btn-export-excel"><i class="fa-solid fa-file-excel mr-1"></i>Excel</button>
                        <button type="button" class="btn btn-danger btn-sm btn-export-pdf"><i class="fa-solid fa-file-pdf mr-1"></i>PDF</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Aset RT --}}
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card collapsed-card" data-card-widget="collapse">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-building mr-1"></i> Aset Rumah Tangga</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body py-2">
                    <form class="form-laporan" data-type="aset-rt">
                        @csrf
                        <div class="form-group">
                            <label class="mb-n1 small">Klasifikasi</label>
                            <select name="klasifikasi[]" class="form-control form-control-sm select2-multi" multiple data-placeholder="Pilih...">
                                @foreach ($klasifikasi->whereIn('id', [3, 4]) as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-n1 small">Kategori</label>
                            <select name="kategori[]" class="form-control form-control-sm select2-multi" multiple data-placeholder="Pilih...">
                                @foreach ($kategoriAset->whereIn('classification_id', [3, 4]) as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-n1 small">Tahun</label>
                                    <select name="tahun" class="form-control form-control-sm">
                                        <option value="">Semua</option>
                                        @for ($y = date('Y'); $y >= date('Y') - 10; $y--)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-n1 small">Bulan</label>
                                    <select name="bulan" class="form-control form-control-sm">
                                        <option value="">Semua</option>
                                        @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $i => $b)
                                            <option value="{{ $i + 1 }}">{{ $b }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm btn-export-excel"><i class="fa-solid fa-file-excel mr-1"></i>Excel</button>
                        <button type="button" class="btn btn-danger btn-sm btn-export-pdf"><i class="fa-solid fa-file-pdf mr-1"></i>PDF</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Lisensi --}}
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card collapsed-card">
                <div class="card-header" data-card-widget="collapse">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-file-code mr-1"></i> Lisensi</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body py-2">
                    <form class="form-laporan" data-type="lisensi">
                        @csrf
                        <div class="form-group">
                            <label class="mb-n1 small">Kategori Lisensi</label>
                            <select name="kategori[]" class="form-control form-control-sm select2-multi" multiple data-placeholder="Pilih...">
                                @foreach ($kategoriLisensi as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-success btn-sm btn-export-excel"><i class="fa-solid fa-file-excel mr-1"></i>Excel</button>
                        <button type="button" class="btn btn-danger btn-sm btn-export-pdf"><i class="fa-solid fa-file-pdf mr-1"></i>PDF</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Pemeliharaan Preventif --}}
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card collapsed-card">
                <div class="card-header" data-card-widget="collapse">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-calendar mr-1"></i> Pemeliharaan Preventif</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body py-2">
                    <form class="form-laporan" data-type="preventif">
                        @csrf
                        <div class="form-group">
                            <label class="mb-n1 small">Klasifikasi</label>
                            <select name="klasifikasi[]" class="form-control form-control-sm select2-multi" multiple data-placeholder="Pilih...">
                                @foreach ($klasifikasi as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-n1 small">Tahun</label>
                                    <select name="tahun" class="form-control form-control-sm">
                                        <option value="">Semua</option>
                                        @for ($y = date('Y'); $y >= date('Y') - 10; $y--)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-n1 small">Bulan</label>
                                    <select name="bulan" class="form-control form-control-sm">
                                        <option value="">Semua</option>
                                        @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $i => $b)
                                            <option value="{{ $i + 1 }}">{{ $b }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm btn-export-excel"><i class="fa-solid fa-file-excel mr-1"></i>Excel</button>
                        <button type="button" class="btn btn-danger btn-sm btn-export-pdf"><i class="fa-solid fa-file-pdf mr-1"></i>PDF</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Pemeliharaan Korektif --}}
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card collapsed-card" data-card-widget="collapse">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-wrench mr-1"></i> Pemeliharaan Korektif</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body py-2">
                    <form class="form-laporan" data-type="korektif">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-n1 small">Tahun</label>
                                    <select name="tahun" class="form-control form-control-sm">
                                        <option value="">Semua</option>
                                        @for ($y = date('Y'); $y >= date('Y') - 10; $y--)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-n1 small">Bulan</label>
                                    <select name="bulan" class="form-control form-control-sm">
                                        <option value="">Semua</option>
                                        @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $i => $b)
                                            <option value="{{ $i + 1 }}">{{ $b }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mb-n1 small">Status</label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="">Semua</option>
                                <option value="Open">Open</option>
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-success btn-sm btn-export-excel"><i class="fa-solid fa-file-excel mr-1"></i>Excel</button>
                        <button type="button" class="btn btn-danger btn-sm btn-export-pdf"><i class="fa-solid fa-file-pdf mr-1"></i>PDF</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tiket --}}
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <div class="card collapsed-card" data-card-widget="collapse">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fa-solid fa-ticket mr-1"></i> Tiket</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body py-2">
                    <form class="form-laporan" data-type="tiket">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-n1 small">Tahun</label>
                                    <select name="tahun" class="form-control form-control-sm">
                                        <option value="">Semua</option>
                                        @for ($y = date('Y'); $y >= date('Y') - 10; $y--)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-n1 small">Bulan</label>
                                    <select name="bulan" class="form-control form-control-sm">
                                        <option value="">Semua</option>
                                        @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $i => $b)
                                            <option value="{{ $i + 1 }}">{{ $b }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mb-n1 small">Jenis Tiket</label>
                            <select name="jenis_tiket" class="form-control form-control-sm">
                                <option value="">Semua</option>
                                <option value="Keluhan">Keluhan</option>
                                <option value="Permintaan">Permintaan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-n1 small">Departemen</label>
                            <select name="departemen" class="form-control form-control-sm">
                                <option value="">Semua</option>
                                <option value="TIK">TIK</option>
                                <option value="Rumah Tangga">Rumah Tangga</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-n1 small">Status</label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="">Semua</option>
                                <option value="Open">Open</option>
                                <option value="Proses">Proses</option>
                                <option value="Pending">Pending</option>
                                <option value="Close">Close</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-success btn-sm btn-export-excel"><i class="fa-solid fa-file-excel mr-1"></i>Excel</button>
                        <button type="button" class="btn btn-danger btn-sm btn-export-pdf"><i class="fa-solid fa-file-pdf mr-1"></i>PDF</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-foot')
    {{-- Select2 --}}
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        function initLaporanSelect2(container) {
            container.find('.select2-multi').each(function() {
                if (!$(this).data('select2')) {
                    $(this).select2({
                        theme: 'bootstrap4',
                        width: '100%',
                        placeholder: 'Pilih...',
                        allowClear: true,
                        closeOnSelect: false,
                    });
                }
            });
        }

        $('.btn-export-excel').on('click', function(e) {
            var form = $(this).closest('form');
            form.attr('action', "{{ route('admin.laporan.export_excel') }}");
            form.attr('method', 'POST');
            $('<input>').attr({
                type: 'hidden',
                name: 'type',
                value: form.data('type')
            }).appendTo(form);
            form.submit();
        });

        $('.btn-export-pdf').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var params = new URLSearchParams();
            form.serializeArray().forEach(function(field) {
                if (field.value) {
                    params.append(field.name, field.value);
                }
            });
            params.append('type', form.data('type'));
            window.open("{{ route('admin.laporan.export_pdf') }}" + '?' + params.toString(), '_blank');
        });

        // Reset error saat input berubah
        $(document).on('change', '.form-laporan input, .form-laporan select', function() {
            $(this).closest('.form-group').find('.text-danger').remove();
        });

        // Inisialisasi Select2 + toggle icon card-tools saat card di-toggle
        $(document).on('expanded.lte.cardwidget collapsed.lte.cardwidget', function(e) {
            var card = $(e.target).closest('.card');
            initLaporanSelect2(card);
        });
    </script>
    <style>
        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
            font-size: 0.8rem;
        }
    </style>
@endpush
