@extends('layouts.backsite-navtab-aset', [
    'id' => $asset->id,
    'classification_id' => $asset->classification_id
])

@section('content-tab')
<form id="editAssetForm">
    @csrf
    @method('PUT') {{-- Gunakan PUT atau PATCH sesuai dengan definisi rute Anda di Laravel --}}
    <div class="card-body">
        <div class="row form-group">
            <div class="form-group col-md-4">
                <label for="tag">Tag Aset *</label>
                <input type="text" name="tag" class="form-control" id="tag" placeholder="Asset Tag" value="{{ $asset->tag ?? '' }}">
                <div id="tag-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-8">
                <label for="name">Nama Aset *</label>
                <input name="name" class="form-control" id="name" placeholder="Asset Name" value="{{ $asset->name ?? '' }}">
                <div id="name-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="category">Kategori</label>
                <select name="category_id" id="category" class="form-control select2">
                    <option value="">Pilih...</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (isset($asset->category_id) && $asset->category_id == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <div id="category_id-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="supplier">Supplier</label>
                <select name="supplier_id" id="supplier" class="form-control select2tag" multiple="multiple" data-placeholder="Pilih.../tambahkan">
                    @foreach ($suppliers as $sup)
                        <option value="{{ $sup->id }}" {{ (isset($asset->supplier_id) && $asset->supplier_id == $sup->id) ? 'selected' : '' }}>{{ $sup->name }}</option>
                    @endforeach
                </select>
                <div id="supplier_id-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="location">Lokasi</label>
                <select name="location_id" id="location" class="form-control select2">
                    <option value="">Pilih...</option>
                    @foreach ($locations as $loc)
                        <option value="{{ $loc->id }}" {{ (isset($asset->location_id) && $asset->location_id == $loc->id) ? 'selected' : '' }}>{{ $loc->name }}</option>
                    @endforeach
                </select>
                <div id="location_id-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="manufacturer">Pabrikan/Merk</label>
                <select name="manufacturer_id" id="manufacturer" class="select2tag" multiple="multiple" data-placeholder="Pilih.../tambahkan">
                    @foreach ($manufacturers as $manufacturer)
                        <option value="{{ $manufacturer->id }}" {{ (isset($asset->manufacturer_id) && $asset->manufacturer_id == $manufacturer->id) ? 'selected' : '' }}>{{ $manufacturer->name }}</option>
                    @endforeach
                </select>
                <div id="manufacturer_id-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="model">Model/Tipe</label>
                <select name="model_id" id="model" class="select2tag" data-placeholder="Pilih.../tambahkan" multiple="multiple">
                    @foreach ($models as $model)
                        <option value="{{ $model->id }}" {{ (isset($asset->model_id) && $asset->model_id == $model->id) ? 'selected' : '' }}>{{ $model->name }}</option>
                    @endforeach
                </select>
                <div id="model_id-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="serial">Serial Number</label>
                <input name="serial" type="text" class="form-control" id="serial" placeholder="Serial Number" value="{{ $asset->serial ?? '' }}">
                <div id="serial-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="status">Status *</label>
                <select name="status_id" id="status" class="form-control select2">
                    <option value="">Pilih...</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->id }}" {{ (isset($asset->status_id) && $asset->status_id == $status->id) ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                </select>
                <div id="status_id-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="useraset">User Aset</label>
                <select name="user_id" id="useraset" class="form-control select2">
                    <option value="">Pilih...</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ (isset($asset->user_id) && $asset->user_id == $user->id) ? 'selected' : '' }}>{{ $user->username }}</option>
                    @endforeach
                </select>
                <div id="user_id-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-4">
                <label for="adminaset">Admin Aset</label>
                <select name="admin_id" id="adminaset" class="form-control select2">
                    <option value="">Pilih...</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ (isset($asset->admin_id) && $asset->admin_id == $user->id) ? 'selected' : '' }}>{{ $user->username }}</option>
                    @endforeach
                </select>
                <div id="admin_id-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-6">
                <label for="purchaseDateInput">Tanggal Perolehan:</label>
                <input type="text" name="purchase_date" id="purchaseDateInput" class="form-control" placeholder="Select date" value="{{ $asset->purchase_date ?? '' }}">
                <div id="purchase_date-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-6">
                <label for="warranty_months">Garansi</label>
                <div class="input-group">
                    <input name="warranty_months" type="number" class="form-control" id="warranty_months" value="{{ $asset->warranty_months ?? '' }}">
                    <div class="input-group-append">
                        <span class="input-group-text">bulan</span>
                    </div>
                </div>
                <div id="warranty_months-error" class="text-danger text-sm mt-1"></div>
            </div>
            <div class="form-group col-md-12">
                <label for="notes">Catatan</label>
                <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Write notes here...">{{ $asset->notes ?? '' }}</textarea>
                <div id="notes-error" class="text-danger text-sm mt-1"></div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="button" id="resetButton" class="btn btn-info mr-2">Reset</button>
            <a href="{{ $asset->classification_id == 2 ? route('admin.asettik.overview', $id) : route('admin.asetrt.overview', $id) }}" class="btn btn-info mr-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>
@endsection

@section('script-foot')
{{-- Pastikan jQuery, Select2 CSS/JS, dan Flatpickr CSS/JS sudah dimuat di layout utama atau di sini --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
{{-- Jika Anda menggunakan tema Bootstrap4 untuk Select2, pastikan CSS-nya juga dimuat --}}
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function() {
        // ID aset dari Blade
        const assetId = {{ $asset->id ?? 'null' }};

        // Data aset awal untuk fungsi reset
        const initialAssetData = {
            id: assetId,
            tag: "{{ $asset->tag ?? '' }}",
            name: "{{ $asset->name ?? '' }}",
            category_id: "{{ $asset->category_id ?? '' }}",
            supplier_id: "{{ $asset->supplier_id ?? '' }}",
            location_id: "{{ $asset->location_id ?? '' }}",
            manufacturer_id: "{{ $asset->manufacturer_id ?? '' }}",
            model_id: "{{ $asset->model_id ?? '' }}",
            serial: "{{ $asset->serial ?? '' }}",
            status_id: "{{ $asset->status_id ?? '' }}",
            user_id: "{{ $asset->user_id ?? '' }}",
            admin_id: "{{ $asset->admin_id ?? '' }}",
            purchase_date: "{{ $asset->purchase_date ?? '' }}",
            warranty_months: "{{ $asset->warranty_months ?? '' }}",
            notes: `{!! addslashes($asset->notes ?? '') !!}` // Menggunakan addslashes untuk handle quotes di notes
        };

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
            multiple: true,
            maximumSelectionLength: 1,
            placeholder: 'Pilih.../tambahkan',
            // Fungsi untuk membuat tag baru jika tidak ada di daftar
            createTag: function (params) {
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

        // Fungsi untuk mengisi form dengan data aset
        function populateForm(asset) {
            $('#tag').val(asset.tag);
            $('#name').val(asset.name);
            $('#serial').val(asset.serial);
            $('#purchaseDateInput').val(asset.purchase_date);
            $('#warranty_months').val(asset.warranty_months);
            $('#notes').val(asset.notes);

            // Set nilai untuk Select2 reguler dan trigger change event
            $('#category').val(asset.category_id).trigger('change');
            $('#location').val(asset.location_id).trigger('change');
            $('#status').val(asset.status_id).trigger('change');
            $('#useraset').val(asset.user_id).trigger('change');
            $('#adminaset').val(asset.admin_id).trigger('change');

            // Set nilai untuk Select2tag (membutuhkan array, bahkan jika hanya satu)
            // Pastikan nilai yang diset adalah ID, bukan nama
            $('#supplier').val(asset.supplier_id ? [asset.supplier_id] : []).trigger('change');
            $('#manufacturer').val(asset.manufacturer_id ? [asset.manufacturer_id] : []).trigger('change');
            $('#model').val(asset.model_id ? [asset.model_id] : []).trigger('change');
        }

        // Panggil populateForm saat DOM siap untuk mengisi form awal
        if (assetId !== null) {
            populateForm(initialAssetData);
        }

        // Fungsi untuk membersihkan semua pesan error validasi
        function clearErrors() {
            $('.text-danger').text('');
        }

        // Handle pengiriman form melalui AJAX
        $('#editAssetForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form default
            clearErrors(); // Bersihkan error sebelumnya

            const formData = new FormData(this);

            // Select2tag (multiple) mungkin tidak otomatis terambil oleh FormData jika ada tag baru atau jika hanya 1 pilihan.
            // Ambil nilai secara manual untuk Select2tag
            // Pastikan Anda mengirimkan ID, bukan teks tag baru jika ada
            const supplierVal = $('#supplier').val();
            formData.set('supplier_id', supplierVal && supplierVal.length > 0 ? supplierVal[0] : '');

            const manufacturerVal = $('#manufacturer').val();
            formData.set('manufacturer_id', manufacturerVal && manufacturerVal.length > 0 ? manufacturerVal[0] : '');

            const modelVal = $('#model').val();
            formData.set('model_id', modelVal && modelVal.length > 0 ? modelVal[0] : '');

            // Mengubah FormData menjadi objek JSON untuk request body
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            // Kirim request AJAX menggunakan Fetch API
            fetch(`/api/assets/${assetId}`, { // Sesuaikan URL API Anda
                method: 'POST', // Gunakan POST karena @method('PUT') akan menanganinya di Laravel
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ambil CSRF token dari meta tag
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    // Jika respons bukan 2xx (misal 422 untuk validasi, 500 untuk server error)
                    return response.json().then(errorData => {
                        throw { status: response.status, data: errorData };
                    });
                }
                return response.json();
            })
            .then(response => {
                // Handle sukses
                alert('Aset berhasil diperbarui!'); // Ganti dengan notifikasi yang lebih baik (e.g., Toastr)
                // Opsional: perbarui UI dengan data baru atau redirect
                // window.location.href = `/admin/asetrt/${assetId}`;
            })
            .catch(error => {
                // Handle error
                console.error('Error:', error);
                if (error.status === 422) {
                    // Error validasi
                    const errors = error.data.errors;
                    for (const field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            // Mengganti '.' dengan '-' untuk ID elemen (misal: 'form.tag' menjadi 'tag-error')
                            // Atau jika nama input langsung 'tag', maka ID errornya 'tag-error'
                            const errorElementId = field.replace(/\./g, '-') + '-error';
                            $(`#${errorElementId}`).text(errors[field][0]);
                        }
                    }
                } else {
                    // Error lainnya
                    alert('Terjadi kesalahan: ' + (error.data.message || 'Silakan coba lagi.'));
                }
            });
        });

        // Handle tombol Reset
        $('#resetButton').on('click', function() {
            populateForm(initialAssetData); // Mengisi ulang form dengan data awal
            clearErrors(); // Bersihkan pesan error
        });
    });
</script>
@endsection
