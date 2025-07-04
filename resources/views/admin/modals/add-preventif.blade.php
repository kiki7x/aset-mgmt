<div class="modal fade" id="add-tugas-preventif" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAddTugasPreventifLabel" aria-hidden="true">
    <div class="modal-dialog modal-l" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddTugasPreventifLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddTugasPreventif">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-8">
                            <label for="picture">Bukti dukung 1 *</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="picture" name="picture" accept="image/,.jpg,.jpeg,.png,.heic,.heif">
                                <label class="custom-file-label" for="picture">Upload Gambar</label>
                            </div>
                            <span id="error-picture" class="text-danger small"></span>
                        </div>
                        <div class="col-4 d-flex justify-content-center">
                            <img id="previewImage" src="https://placehold.jp/70x70.png" alt="Preview Gambar" class="img img-thumbnail" height="50">
                        </div>
                    </div>
                    <div class="form-row mt-5">
                        <div class="col-8">
                            <label for="document">Bukti dukung 2 *</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="document" name="document" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                <label class="custom-file-label" for="document">Upload Dokumen</label>
                            </div>
                            <span id="error-file" class="text-danger small"></span>
                        </div>
                        <div class="col-4 d-flex justify-content-center">
                            <img id="previewDocument" src="https://placehold.jp/70x70.png" alt="Preview Dokumen" class="img img-thumbnail" height="50">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="notes">Catatan *</label>
                            <textarea class="form-control rows-3" id="notes" name="notes"></textarea>
                            <span id="error-notes" class="text-danger small"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="name" value="Pemeliharaan Selesai" required>
                            <label for="customCheckbox1" class="custom-control-label font-weight-normal">Saya telah menyelesaikan tugas pemeliharaan ini *</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script-foot')
    <script>
        // Fungsi tampilkan modal untuk menyelesaikan tugas preventif
        function showModalAddTugasPreventif(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.asetrt.pemeliharaan.addPreventif', ['id' => ':id']) }}".replace(':id', id),
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#formAddTugasPreventif')[0].reset();
                    $('#error-*').text('');
                },
                success: function(data) {
                    $('#add-tugas-preventif').modal('show');
                    $('#formAddTugasPreventif')[0].reset();
                    $('#modalAddTugasPreventiflabel, .modal-title').html('Tindak lanjut Pemeliharaan Preventif untuk: <span class="badge badge-info">' + data.maintenance_schedule.name + '</span><span class="font-weight-bold"> ' + data.asset.name + '</span> periode: <span class="badge badge-info">' + moment(data.maintenance_schedule.next_date).format('ll') + '</span>');
                    $('#error-tugasPreventifName').text('');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('#error-tugasPreventifName').text(errors.name ? errors.name[0] : '');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memuat data. Silakan coba lagi.',
                        });
                    }
                }
            })
        }

        // Handle Preview gambar dan dokumen
        function previewImage() {
            const file = $('#picture').files[0];
            const preview = $('#previewImage');
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        function previewDocument() {
            const file = $('#document').files[0];
            const preview = $('#previewDocument');
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        $(document).ready(function() {
            $('#picture').on('change', function() {
                previewImage();
            });
            $('#document').on('change', function() {
                previewDocument();
            });
        });

        // Fungsi Simpan
        $('#formAddTugasPreventif').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.asetrt.pemeliharaan.preventifStore', ['id' => ':id']) }}".replace(':id', '{{ $asset->id }}'),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Tugas pemeliharaan preventif berhasil ditambahkan.',
                    }).then(() => {
                        $('#add-tugas-preventif').modal('hide');
                        // Reload or update the relevant section of the page
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('#error-picture').text(errors.picture ? errors.picture[0] : '');
                        $('#error-file').text(errors.document ? errors.document[0] : '');
                        $('#error-notes').text(errors.notes ? errors.notes[0] : '');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                        });
                    }
                }
            });
        });

    </script>
@endpush
