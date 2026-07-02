@extends('layouts.backsite-navtab-license', [
    'id' => $license->id,
])

@push('script-head')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content-tab')
    <form id="formEditLicense">
        @csrf
        @method('PATCH')
        <div class="card-body">
            <div class="row form-group">
                <input type="hidden" name="id" value="{{ $license->id }}">
                <div class="form-group col-md-4">
                    <label for="tag">Tag <span class="text-danger">*</span></label>
                    <input type="text" name="tag" class="form-control" id="tag" value="{{ $license->tag ?? '' }}" readonly>
                    <span id="error-tag" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-8">
                    <label for="name">Nama Lisensi <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $license->name ?? '' }}" required>
                    <span id="error-name" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="serial">Serial <span class="text-danger">*</span></label>
                    <input type="text" name="serial" class="form-control" id="serial" value="{{ $license->serial ?? '' }}" required>
                    <span id="error-serial" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="status_id">Status <span class="text-danger">*</span></label>
                    <select name="status_id" id="status_id" class="form-control select2" required>
                        <option value="">-- Pilih Status --</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ $license->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <span id="error-status_id" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="category_id">Kategori <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-control select2" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $license->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <span id="error-category_id" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                    <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ $license->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    <span id="error-supplier_id" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="seats">Seats/Jumlah <span class="text-danger">*</span></label>
                    <input type="text" name="seats" class="form-control" id="seats" value="{{ $license->seats ?? '' }}" required>
                    <span id="error-seats" class="text-danger small"></span>
                </div>
                <div class="form-group col-md-12">
                    <label for="notes">Notes</label>
                    <textarea name="notes" class="form-control" id="notes" rows="3">{{ $license->notes ?? '' }}</textarea>
                    <span id="error-notes" class="text-danger small"></span>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.license.overview', $id) }}" class="btn btn-info mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
@endsection

@section('script-foot')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
            });

            $('#formEditLicense').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let id = $('input[name="id"]').val();

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: `{{ url('admin/license/update') }}/${id}`,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Lisensi berhasil diperbarui.',
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $('.text-danger').text('');
                            $.each(errors, function(key, value) {
                                $('#error-' + key).text(value[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Cek kembali isian form.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat memperbarui lisensi.',
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
