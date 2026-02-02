<div class="modal fade" id="add-tugas-preventif" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAddTugasPreventifLabel" aria-hidden="true">
    <div class="modal-dialog modal-l" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddTugasPreventifLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddTugasPreventif" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- Bukti dukung --}}
                    <div class="form-group">
                        <label for="attachment">Bukti dukung <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="form-control custom-file-input" id="attachment" name="attachment" accept=".jpg, .jpeg, .png, .heic, .heif, .pdf">
                            <label class="custom-file-label" for="attachment">Upload bukti dukung</label>
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, HEIC, HEIF, PDF (Max: 2MB)</small>
                        </div>
                        <span id="error-attachment" class="text-danger small"></span>
                    </div>
                    {{-- Biaya --}}
                    <div class="form-group">
                        <label for="cost">Biaya <span class="text-danger">*</span></label>
                        <input type="string" class="form-control" id="cost" name="cost" placeholder="Rp 0">
                        <span id="error-cost" class="text-danger small"></span>
                    </div>
                    {{-- Catatan --}}
                    <div class="form-group">
                        <label for="notes">Catatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
                        <span id="error-notes" class="text-danger small"></span>
                    </div>
                    {{-- Periode --}}
                    <div class="form-group">
                        <input type="hidden" id="period" name="period" value="">
                        <span id="error-period" class="text-danger small"></span>
                    </div>
                    {{-- Checkbox --}}
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="name" value="" required>
                            <label for="customCheckbox1" class="custom-control-label font-weight-normal">Saya telah menyelesaikan tugas pemeliharaan ini <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <p class="text-muted font-italic">Tanda <span class="text-danger">*</span> wajib diisi</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
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
        // buat script front end untuk memanipulasi tampilan id cost dalam format Rp
        $('#cost').on('input', function() {
            var value = $(this).val();
            // Hapus semua karakter non-digit
            value = value.replace(/\D/g, '');
            // Format sebagai mata uang Rupiah
            if (value) {
                value = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(value);
            }
            $(this).val(value);
        });
    </script>
    <script>
        // Fungsi tampilkan modal untuk menyelesaikan tugas preventif
        function showModalAddPreventif(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.asetrt.pemeliharaan.preventifAdd', ['id' => ':id']) }}".replace(':id', id),
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
                    $('#formAddTugasPreventif input[name="name"]').val(data.maintenance_schedule.name); // Set nilai checkbox sesuai nama tugas
                    $('#formAddTugasPreventif input[name="period"]').val(data.maintenance_schedule.next_date); // Set nilai periode
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

        // Handle Submit
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
                        text: 'Pemeliharaan preventif berhasil ditindak lanjuti.',
                    }).then(() => {
                        $('#add-tugas-preventif').modal('hide');
                        $('#tablePemeliharaanPreventif').DataTable().ajax.reload();
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('#error-attachment').text(errors.attachment ? errors.attachment[0] : '');
                        $('#error-cost').text(errors.cost ? errors.cost[0] : '');
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
