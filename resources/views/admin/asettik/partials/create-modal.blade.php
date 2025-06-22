<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Tambah Aset TIK</h4>
                <button type="button" class="close" id="btnHeaderCloseModal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form id="formCreateAsetTIK" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        {{-- Nama Aset --}}
                        <div class="form-group col-md-8">
                            <label for="name">Nama Aset <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control">
                            <span class="text-danger small" id="error-name"></span>
                        </div>

                        {{-- Kategori --}}
                        <div class="form-group col-md-4">
                            <label for="category_id">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control select2">
                                <option value="">None</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger small" id="error-category_id"></span>
                        </div>

                        {{-- Manufacturer --}}
                        <div class="form-group col-md-4">
                            <label for="manufacturer_id">Merk/Pabrikan <span class="text-danger">*</span></label>
                            <select name="manufacturer_id[]" id="manufacturer_id" class="form-control select2tag"
                                multiple>
                                @foreach ($manufacturers as $manufacturer)
                                    <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger small" id="error-manufacturer_id"></span>
                        </div>

                        {{-- Model --}}
                        <div class="form-group col-md-4">
                            <label for="model_id">Tipe/Model <span class="text-danger">*</span></label>
                            <select name="model_id[]" id="model_id" class="form-control select2tag" multiple>
                                @foreach ($models as $model)
                                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger small" id="error-model_id"></span>
                        </div>

                        {{-- Serial --}}
                        <div class="form-group col-md-4">
                            <label for="serial">Serial Number <span class="text-danger">*</span></label>
                            <input type="text" name="serial" id="serial" class="form-control" placeholder="Unik">
                            <span class="text-danger small" id="error-serial"></span>
                        </div>

                        {{-- Supplier --}}
                        <div class="form-group col-md-4">
                            <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                            <select name="supplier_id[]" id="supplier_id" class="form-control select2tag" multiple>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger small" id="error-supplier_id"></span>
                        </div>

                        {{-- Location --}}
                        <div class="form-group col-md-4">
                            <label for="location_id">Penempatan <span class="text-danger">*</span></label>
                            <select name="location_id" id="location_id" class="form-control select2">
                                <option value="">None</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger small" id="error-location_id"></span>
                        </div>

                        {{-- Status --}}
                        <div class="form-group col-md-4">
                            <label for="status_id">Status <span class="text-danger">*</span></label>
                            <select name="status_id" id="status_id" class="form-control select2">
                                <option value="">None</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger small" id="error-status_id"></span>
                        </div>

                        {{-- User --}}
                        <div class="form-group col-md-4">
                            <label for="user_id">Pengguna Aset <span class="text-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-control select2">
                                <option value="">None</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger small" id="error-user_id"></span>
                        </div>

                        {{-- Purchase Date --}}
                        <div class="form-group col-md-4">
                            <label for="purchaseDateInput">Tanggal Perolehan <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" id="purchaseDateInput" class="form-control">
                            <span class="text-danger small" id="error-purchase_date"></span>
                        </div>

                        {{-- Warranty --}}
                        <div class="form-group col-md-4">
                            <label for="warranty_months">Garansi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="warranty_months" id="warranty_months"
                                    class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text">bulan</span>
                                </div>
                            </div>
                            <span class="text-danger small" id="error-warranty_months"></span>
                        </div>

                        {{-- Notes --}}
                        <div class="form-group col-md-12">
                            <label for="notes">Catatan</label>
                            <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
                            <span class="text-danger small" id="error-notes"></span>
                        </div>
                    </div>
                    <p class="text-muted">Tanda <span class="text-danger">*</span> wajib diisi</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="btnResetForm">Reset</button>
                    <button type="button" class="btn btn-secondary" id="btnCloseModal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('script-foot')
    {{-- Initialize --}}
    <script>
        $(document).ready(function() {
            // Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#createModal'),
                width: '100%',
            });

            $('.select2tag').select2({
                tags: true,
                dropdownParent: $('#createModal'),
                width: '100%',
                maximumSelectionLength: 1,
                placeholder: 'Pilih atau tambahkan...',
            });
        });
    </script>

    {{-- SubmitScript --}}
    <script>
        $(document).ready(function() {
            $('#formCreateAsetTIK').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);

                $.ajax({
                    url: "{{ route('admin.asettik.store', ['classification' => 'tik']) }}",
                    method: "POST",
                    data: form.serialize(),
                    success: function(res) {
                        $('#createModal').modal('hide');
                        form[0].reset();
                        $('.select2, .select2tag').val(null).trigger('change');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil disimpan!',
                        })

                        $('#tableAsettik').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $(`#error-${key}`).text(value[0]);
                            });
                        }
                    }
                });
            });
        });
    </script>

    {{-- ModalManagement --}}
    <script>
        $(document).ready(function() {
            $('#btnCloseModal, #btnHeaderCloseModal').on('click', function() {
                $('#createModal').modal('hide');
            });

            $('#btnResetForm').on('click', function() {
                $('#formCreateAsetTIK')[0].reset();
                $('.select2, .select2tag').val(null).trigger('change');
                $('.text-danger').text('');
            });
        });
    </script>
@endpush