@extends('layouts.backsite-navtab-aset', [
    'id' => $asset->id,
    'classification_id' => $asset->classification_id,
])

@push('script-head')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content-tab')
    <form id="formEditAsset">
        @csrf
        @method('PATCH') {{-- Gunakan PUT atau PATCH sesuai dengan definisi rute Anda di Laravel --}}
        <div class="card-body">
            <div class="row form-group">
                <input type="text" name="id" value="{{ $asset->id }}" hidden>
                <div class="form-group col-md-4">
                    <label for="tag">Tag Aset *</label>
                    <input type="text" name="tag" class="form-control" id="tag" placeholder="Asset Tag" value="{{ $asset->tag ?? '' }}" readonly>
                    <span id="error-tag" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-8">
                    <label for="name">Nama Aset *</label>
                    <input name="name" class="form-control" id="name" placeholder="Asset Name" value="{{ $asset->name ?? '' }}">
                    <span id="error-name" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="category">Kategori</label>
                    <select name="category_id" id="category" class="form-control select2">
                        <option value="">Pilih...</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"{{ isset($asset->category_id) && $asset->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger small" id="error-category_id"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="supplier">Supplier</label>
                    <select name="supplier_id[]" id="supplier" class="form-control select2tag" data-placeholder="Pilih.../tambahkan" multiple>
                        @foreach ($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ isset($asset->supplier_id) && $asset->supplier_id == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                        @endforeach
                    </select>
                    <div id="error-supplier_id" class="text-danger small"></div>
                </div>
                <div class="form-group col-md-4">
                    <label for="location">Lokasi</label>
                    <select name="location_id" id="location" class="form-control select2">
                        <option value="">Pilih...</option>
                        @foreach ($locations as $loc)
                            <option value="{{ $loc->id }}" {{ isset($asset->location_id) == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                    <span id="error-location_id" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="manufacturer">Pabrikan/Merk</label>
                    <select name="manufacturer_id[]" id="manufacturer" class="select2tag" data-placeholder="Pilih.../tambahkan" multiple>
                        @foreach ($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}" {{ isset($asset->manufacturer_id) && $asset->manufacturer_id == $manufacturer->id ? 'selected' : '' }}>{{ $manufacturer->name }}</option>
                        @endforeach
                    </select>
                    <span id="error-manufacturer_id" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="model">Model/Tipe</label>
                    <select name="model_id[]" id="model" class="select2tag" data-placeholder="Pilih.../tambahkan" multiple>
                        @foreach ($models as $model)
                            <option value="{{ $model->id }}" {{ isset($asset->model_id) && $asset->model_id == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                        @endforeach
                    </select>
                    <span id="error-model_id" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="serial">Serial Number</label>
                    <input name="serial" type="text" class="form-control" id="serial" placeholder="Serial Number" value="{{ $asset->serial ?? '' }}">
                    <span id="error-serial" class="text-danger small">
                </div>
                <div class="form-group col-md-4">
                    <label for="status">Status *</label>
                    <select name="status_id" id="status" class="form-control select2">
                        <option value="">Pilih...</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ isset($asset->status_id) && $asset->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <span id="error-status_id" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="useraset">User Aset</label>
                    <select name="user_id" id="useraset" class="form-control select2">
                        <option value="">Pilih...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ isset($asset->user_id) && $asset->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                        @endforeach
                    </select>
                    <span id="error-user_id" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="adminaset">Admin Aset</label>
                    <select name="admin_id" id="adminaset" class="form-control select2">
                        <option value="">Pilih...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ isset($asset->admin_id) && $asset->admin_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                        @endforeach
                    </select>
                    <span id="error-admin_id" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="purchaseDateInput">Tanggal Perolehan:</label>
                    <input type="text" name="purchase_date" id="purchaseDateInput" class="form-control" placeholder="Select date" value="{{ $asset->purchase_date ?? '' }}">
                    <span id="error-purchase_date" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="warranty_months">Garansi</label>
                    <div class="input-group">
                        <input name="warranty_months" type="number" class="form-control" id="warranty_months" value="{{ $asset->warranty_months ?? '' }}">
                        <div class="input-group-append">
                            <span class="input-group-text">bulan</span>
                        </div>
                    </div>
                    <span id="error-warranty_months" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="notes">Catatan</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Write notes here...">{{ $asset->notes ?? '' }}</textarea>
                    <span id="notes-error" class="text-danger small"></span>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="javascript:void(0)" type="button" id="resetButton" class="btn btn-info mr-2" onclick="window.location.reload()">Reset</a>
                <a href="{{ $asset->classification_id == 2 ? route('admin.asettik.overview', $id) : route('admin.asetrt.overview', $id) }}" class="btn btn-info mr-2">Batal</a>
                <button id="submitFormEdit" type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
@endsection

@section('script-foot')
    <!-- InputMask -->
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    {{-- Laravel javascript Validation --}}
    {{-- <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js') }}"></script> --}}
    {{-- {!! JsValidator::formRequest('App\Http\Requests\UpdateAssetRequest', '#formEditAsset') !!} --}}

    <script>
        // $(document).ready(function() {
        // Fungsi untuk menginisialisasi Select2
        function initSelect2(selector, options = {}) {
            $(selector).select2({
                theme: 'bootstrap4', // Pastikan tema Bootstrap 4 tersedia
                width: '100%',
                ...options
            });
        }

        // Inisialisasi Select2 untuk field non-tag
        initSelect2('#category');
        initSelect2('#location');
        initSelect2('#status');
        initSelect2('#useraset');
        initSelect2('#adminaset');

        // Inisialisasi Select2 untuk field tag (multiple dengan max 1 selection)
        initSelect2('.select2tag', {
            tags: true,
            maximumSelectionLength: 1,
            placeholder: 'Pilih.../tambahkan',
            // Fungsi untuk membuat tag baru jika tidak ada di daftar
            createTag: function(params) {
                if (params.term.trim() === '') {
                    return null;
                }
                return {
                    id: params.term, // ID baru bisa berupa teks input
                    text: params.term,
                    newTag: true // Flag untuk menandakan tag baru
                };
            }
        });

        // Inisialisasi Flatpickr
        flatpickr("#purchaseDateInput", {
            dateFormat: "Y-m-d",
            allowInput: true, // Memungkinkan input manual
            // Anda bisa menambahkan opsi lain di sini, misalnya:
            // defaultDate: initialAssetData.purchase_date,
            // enableTime: false,
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handle pengiriman form melalui AJAX
            $('#formEditAsset').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let id = $('#id').val(); //ambil value dari hidden input asset_id

                $.ajax({
                    url: "{{ route('admin.asettik.update', $id) }}",
                    method: "POST", // Laravel interprets @method('PUT') when using POST
                    data: form.serialize(),
                    success: function(res) {
                        // $('.select2, .select2tag').val(null).trigger('change'); // Reset Select2
                        // $('.text-danger').text(''); // clear validation error

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil diperbarui!',
                        })
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.text-danger').text(''); // clear old errors
                            $.each(errors, function(key, value) {
                                $(`#error-${key}`).text(value[0]);
                                $(`[name="${key}"]`).addClass('is-invalid');
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Cek kembali isian form.',
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat memperbarui data.',
                            });
                        }
                    }
                })
            });
        });
    </script>
@endsection
