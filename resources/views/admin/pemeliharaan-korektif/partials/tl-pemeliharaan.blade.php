<div class="modal fade" id="modal-ubah-status" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalUbahStatusLabel">
    <div class="modal-dialog modal-l" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUbahStatusLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formUbahStatus" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    {{-- form ubah status --}}
                    <div class="form-group">
                        <label for="status">Ubah Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="ubahstatus" name="status">
                            <option name="status" value="">-- Pilih Status --</option>
                            <option name="status" value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                            <option name="status" value="Ditahan">Ditahan</option>
                        </select>
                        <span id="error-ubahstatus" class="text-danger small"></span>
                    </div>
                    {{-- buat inpu textarea untuk alasan ditahan --}}
                    <div class="form-group">
                        <label for="notes">Alasan Ditahan <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="5" id="notes" name="notes"></textarea>
                        <span id="error-notes" class="text-danger small"></span>
                    </div>
                    <p class="text-muted font-italic">Tanda <span class="text-danger">*</span> wajib diisi</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-tindak-lanjut" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalTlPemeliharaanLabel">
    <div class="modal-dialog modal-l" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTlPemeliharaanLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formTindakLanjut" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
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
                    {{-- Status --}}
                    <div class="form-group">
                        <input type="hidden" id="status" name="status" value="Selesai">
                        <span id="error-status" class="text-danger small"></span>
                    </div>
                    {{-- Checkbox --}}
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="" value="" required>
                            <label for="customCheckbox1" class="custom-control-label font-weight-normal">Saya telah menyelesaikan tugas pemeliharaan ini <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <p class="text-muted font-italic">Tanda <span class="text-danger">*</span> wajib diisi</p>
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
    <script>
        // $(document).ready(function() {
        // ini untuk custom file input agar berfungsi reaktif
        bsCustomFileInput.init();
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

        // $('.select2').select2({
        //     // theme: 'bootstrap4',
        //     // width: '100%',
        //     // placeholder: "Pilih",
        //     // allowClear: true
        //     theme: 'bootstrap4',
        //     dropdownParent: $('#modal-ubah-status'),
        //     width: '100%',
        //     placeholder: "Pilih...",
        //     allowClear: true
        // });
        // });
    </script>

    <script>
        // tampilkan elemen alasan ditahan ketika memilih opsi Ditahan
        $('#notes').parent().show();
        $('#ubahstatus').on('change', function() {
            if ($(this).val() === 'Ditahan') {
                    $('#notes').parent().show();
                    // tambahkan required pada textarea alasan ditahan
                    $('#notes').prop('required', true);
                } else {
                    $('#notes').parent().hide();
                    $('#notes').val('');
                    // hapus required pada textarea alasan ditahan
                    $('#notes').prop('required', false);
                }
            });

        // Fungsi tampilkan modal untuk menyelesaikan tugas preventif
        function showModalUbahStatus(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.pemeliharaan.edit', ['id' => ':id']) }}".replace(':id', id),
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#formUbahStatus')[0].reset();
                    $('#error-*').text('');
                    // hide elemen input alasan ditahan ambil dari from-groupnya
                    $('#notes').parent().hide();

                },
                success: function(data) {
                    $('#modal-ubah-status').modal('show').data('id', id); // <--- Simpan ID tugas di modal
                    $('#modalUbahStatuslabel, .modal-title').html('Tindak lanjut Pemeliharaan Korektif untuk: <span class="badge badge-info"> ' + data.name + '</span>');
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

        // Fungsi tampilkan modal untuk menyelesaikan tugas preventif
        function showModalTindakLanjut(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.pemeliharaan.edit', ['id' => ':id']) }}".replace(':id', id),
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#formTindakLanjut')[0].reset();
                    $('#error-*').text('');
                },
                success: function(data) {
                    $('#modal-tindak-lanjut').modal('show').data('id', id); // <--- Simpan ID tugas di modal
                    $('#modalAddTugasPreventiflabel, .modal-title').html('Tindak lanjut Pemeliharaan Preventif untuk: <span class="badge badge-info">' + data.name + '</span>');
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

        // Handle Submit Ubah Status
        $('#formUbahStatus').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var id = $('#modal-ubah-status').data('id'); // Ganti dengan ID pemeliharaan yang sesuai
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.pemeliharaan.ubahstatus', ['id' => ':id']) }}".replace(':id', id),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Pemeliharaan berhasil diperbarui.',
                    }).then(() => {
                        $('#modal-ubah-status').modal('hide');
                        $('#tablePemeliharaan').DataTable().ajax.reload();
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('#error-ubahstatus').text(errors.status ? errors.status[0] : '');
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

        // Handle Submit Tindak Lanjut
        $('#formTindakLanjut').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var id = $('#modal-tindak-lanjut').data('id'); // Ganti dengan ID pemeliharaan yang sesuai
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.pemeliharaan.tindaklanjut', ['id' => ':id']) }}".replace(':id', id),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Pemeliharaan berhasil ditindak lanjuti.',
                    }).then(() => {
                        $('#modal-tindak-lanjut').modal('hide');
                        $('#tablePemeliharaanSelesai').DataTable().ajax.reload();
                        $('#tablePemeliharaan').DataTable().ajax.reload();
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
