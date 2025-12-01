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
                    <div class="form-group">
                        <label for="attachment">Bukti dukung *</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="attachment" name="attachment" accept="image/,.jpg,.jpeg,.png,.heic,.heif.pdf,.doc,.docx,.xls,.xlsx">
                            <label class="custom-file-label" for="attachment">Upload bukti dukung</label>
                        </div>
                        <span id="error-attachment" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="notes">Catatan *</label>
                        <textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
                        <span id="error-notes" class="text-danger small"></span>
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
                    // $('#add-tugas-preventif').modal('show');
                    $('#add-tugas-preventif').modal('show').data('schedule-id', id); // <--- Simpan ID tugas di modal
                    $('#formAddTugasPreventif')[0].reset();
                    $('#modalAddTugasPreventiflabel, .modal-title').html('Tindak lanjut Pemeliharaan Preventif untuk: <span class="badge badge-info">' + data.maintenance_schedule.name + '</span><span class="font-weight-bold"> ' + data.asset.name +
                        '</span> periode: <span class="badge badge-info">' + moment(data.maintenance_schedule.next_date).format('ll') + '</span>');
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

        // Fungsi Simpan
        $('#formAddTugasPreventif').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var scheduleId = $('#add-tugas-preventif').data('schedule-id'); // Ganti dengan ID jadwal yang sesuai
            var assetId = "{{ $asset->id }}"; // Ganti dengan ID aset yang sesuai
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.asetrt.pemeliharaan.preventifStore', ['id' => ':id']) }}".replace(':id', scheduleId),
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
