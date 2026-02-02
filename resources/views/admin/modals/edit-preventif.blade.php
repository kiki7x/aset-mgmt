<div class="modal fade" id="modal-edit-preventif" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalEditPreventifLabel" aria-hidden="true">
    <div class="modal-dialog modal-l" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditPreventifLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditPreventif" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Nama Tugas Preventif</label>
                        <input type="text" class="form-control" id="edit_name" name="edit_name" readonly>
                        <span id="error-edit_name" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_aset">Nama Aset</label>
                        <input type="text" class="form-control" id="edit_aset" name="edit_aset" readonly>
                        <span id="error-edit_aset" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_period">Periode</label>
                        <input type="text" class="form-control" id="edit_period" name="edit_period" readonly>
                        <span id="error-edit_period" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="current_attachment">Bukti dukung saat ini</label>
                        <div id="current-attachment">
                            <!-- Isi akan diisi secara dinamis melalui JavaScript -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="attachment"></label>
                        <div class="custom-file">
                            <input type="file" class="form-control custom-file-input" id="attachment" name="attachment" accept=".jpg, .jpeg, .png, .heic, .heif, .pdf">
                            <label class="custom-file-label" for="attachment">Upload ulang bukti dukung</label>
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, HEIC, HEIF, PDF (Max: 2MB)</small>
                        </div>
                        <span id="error-attachment" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_notes">Catatan *</label>
                        <textarea class="form-control" rows="5" id="edit_notes" name="edit_notes"></textarea>
                        <span id="error-edit_notes" class="text-danger small"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script-foot')
    <!-- ini untuk custom file input agar berfungsi reaktif -->
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        // Fungsi tampilkan modal untuk Edit preventif
        function showModalEditPreventif(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.asetrt.pemeliharaan.preventifEdit', ['id' => ':id']) }}".replace(':id', id),
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#formEditPreventif')[0].reset();
                    $('#error-*').text('');
                },
                success: function(data) {
                    $('#formEditPreventif')[0].reset();
                    $('#modal-edit-preventif').modal('show').data('schedule-id', id); // <--- Simpan ID tugas di modal
                    $('#modalEditPreventifLabel, .modal-title').html('Form Edit Pemeliharaan Preventif');
                    $('#formEditPreventif input[name="edit_name"]').val(data.name);
                    $('#formEditPreventif input[name="edit_aset"]').val(data.asset_name);
                    // Tampilkan attachment saat ini
                    var currentAttachmentHtml = data.attachment ?
                        `<a href="{{ asset('storage') }}/${data.attachment}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-file-arrow-down"></i> Lihat ${data.attachment}</a>` :
                        'Tidak ada bukti dukung';
                    $('#current-attachment').html(currentAttachmentHtml);
                    $('#formEditPreventif input[name="edit_period"]').val(data.period); // Set nilai periode
                    $('#formEditPreventif textarea[name="edit_notes"]').val(data.notes);
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

        // Handle Update
        $('#formEditTugasPreventif').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var scheduleId = $('#modal-edit-preventif').data('schedule-id'); // Ganti dengan ID jadwal yang sesuai
            var assetId = "{{ $asset->id }}"; // Ganti dengan ID aset yang sesuai
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.asetrt.pemeliharaan.preventifUpdate', ['id' => ':id']) }}".replace(':id', scheduleId),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Pemeliharaan preventif berhasil ditindak lanjuti.',
                    }).then(() => {
                        $('#modal-edit-preventif').modal('hide');
                        // Reload or update the relevant section of the page
                        $('#tablePemeliharaanPreventif').DataTable().ajax.reload();
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('#error-attachment').text(errors.attachment ? errors.attachment[0] : '');
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
