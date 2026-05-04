<div class="modal fade" id="add-schedule" data-backdrop="static" tabindex="-1" aria-labelledby="add-schedule-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-schedule-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="formJadwalPemeliharaan">
                    {{-- Nama Barang & Hidden Input --}}
                    <div class="form-group">
                        <p class="h5">{{ $asset->tag }} - {{ $asset->name }}</p>
                        <input type="text" class="form-control d-none" id="asset_id" name="asset_id" value="{{ $asset->id }}">
                        <input type="text" class="form-control d-none" id="status" name="status" value="aktif">
                    </div>

                    {{-- Klasifikasi Aset --}}
                    <div class="form-group">
                        <label for="klasifikasi">Klasifikasi</label>
                        <select class="form-control" id="klasifikasi" name="klasifikasi" disabled>
                            <option value="1" @if ($asset->classification_id == 1) selected @endif>None</option>
                            <option value="2" @if ($asset->classification_id == 2) selected @endif>TIK</option>
                            <option value="3" @if ($asset->classification_id == 3) selected @endif>Kendaraan</option>
                            <option value="4" @if ($asset->classification_id == 4) selected @endif>Mesin/Elektronik
                            </option>
                        </select>
                    </div>

                    <div id="radioTik" class="form-group p-3 border rounded mb-3 bg-light">
                        <label class="text-primary font-weight-normal">Detail Pemeliharaan TIK: <span class="text-danger">*</span></label>
                        <div class="form-group">
                            <label>Tugas:</label>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="service_berkala" name="name" value="Cek Kondisi & Service Berkala">
                                    <label for="service_berkala" class="custom-control-label">1. Cek Kondisi & Servis Berkala</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="radioKendaraan" class="form-group border p-3 bg-light">
                        <label class="text-primary font-weight-normal">Detail Pemeliharaan
                            Kendaraan: <span class="text-danger">*</span></label>
                        <p class="text-muted small">Pilih tugas pemeliharaan yang relevan.</p>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="kendaraan_pajak_stnk" name="name" value="Pajak STNK">
                            <label for="kendaraan_pajak_stnk" class="custom-control-label">1. Pajak STNK</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="kendaraan_service_berkala" name="name" value="Service Berkala">
                            <label for="kendaraan_service_berkala" class="custom-control-label">2. Service Berkala</label>
                        </div>
                    </div>

                    <div id="radioMesinElektronik" class="form-group p-3 border rounded mb-3 bg-light">
                        <label class="text-primary font-weight-normal">Detail Pemeliharaan Mesin/Elektronik: <span class="text-danger">*</span></label>
                        <div class="form-group">
                            <label>Tugas:</label>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="elektronik_service_berkala" name="name" value="Cek Kondisi & Service Berkala">
                                    <label for="elektronik_service_berkala" class="custom-control-label">1. Cek Kondisi & Service Berkala</label>
                                </div>
                            </div>
                            <span class="text-danger small" id="error-name"></span>
                        </div>
                    </div>
                    {{-- Frekuensi Pemeliharaan --}}
                    <div class="form-group">
                        <label for="frequency">Frekuensi Pemeliharaan: <span class="text-danger">*</span></label>
                        <select class="form-control" id="frequency" name="frequency">
                            <option value="">-- Pilih --</option>
                            <option value="3">Setiap 3 bulan sekali</option>
                            <option value="4">Setiap 4 bulan sekali</option>
                            <option value="6">Setiap 6 bulan sekali</option>
                            <option value="12">Setiap 12 bulan sekali</option>
                        </select>
                        <span class="text-danger small" id="error-frequency"></span>
                    </div>
                    {{-- <div class="form-group">
                        <label for="start">Waktu Pemeliharaan <span class="text-danger">*</span></label>
                        <div>
                            <input type="text" id="start" width="276" type="text" class="form-control" name="start" placeholder="yyyy-mm-dd" />
                        </div>
                        <span class="text-danger small" id="error-start"></span>
                    </div> --}}
                    <!-- Tanggal Selanjutnya -->
                    <div class="form-group">
                        <label for="end">Waktu Pemeliharaan</label>
                        <div>
                            <input id="end" width="276" type="text" class="form-control" name="end" placeholder="DD MMM YYYY" />
                        </div>
                        <span class="text-danger small" id="error-end"></span>
                    </div>
                    {{-- Reminder day --}}
                    <div class="form-group">
                        <label for="reminder">Pengingat Sebelum Pemeliharaan (hari)</label>
                        <input type="number" id="reminder" name="reminder" class="form-control" value="7" min="0">
                        <small class="form-text text-muted">Masukkan jumlah hari sebelum tanggal pemeliharaan untuk menerima pengingat.</small>
                        <span class="text-danger small" id="error-reminder"></span>
                    </div>
                    {{-- Hidden Input --}}
                    <!-- Tanggal Mulai -->
                    <input type="hidden" id="start" width="276" type="text" class="form-control" name="start" placeholder="yyyy-mm-dd" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button id="submitJadwalPemeliharaan" type="submit" class="btn btn-success">Jadwalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('script-foot')
    <script>
        function showModalAddJadwalPemeliharaan() {
            $('#add-schedule-label').text('Setup Jadwal Pemeliharaan');
            $('#formJadwalPemeliharaan')[0].reset();
            $('#add-schedule').modal('show');
        }
        $('#end').datepicker({
            format: "dd M yyyy",
            autoclose: true,
            todayHighlight: true,
            orientation: "auto",
            todayBtn: "linked",
        });

        // dengarkan perubahan pada input start dan copy nilainya ke input end
        $('#end').on('change', function() {
            $('#start').val($(this).val());
        });

        // Pastikan dokumen siap sebelum menjalankan script jQuery
        $(document).ready(function() {

            function toggleRadioGroups(selectedValue) {
                // Sembunyikan semua bagian form detail terlebih dahulu
                $('#radioTik').hide();
                $('#radioKendaraan').hide();
                $('#radioMesinElektronik').hide();

                // Tampilkan bagian form yang sesuai berdasarkan pilihan
                if (selectedValue === '2') {
                    $('#radioTik').removeClass('d-none').show();
                    $('input[name="name"]').prop('checked', false);
                } else if (selectedValue === '3') {
                    $('#radioKendaraan').removeClass('d-none').show();
                    $('input[name="name"]').prop('checked', false);
                } else if (selectedValue === '4') {
                    $('#radioMesinElektronik').removeClass('d-none').show();
                    $('input[name="name"]').prop('checked', false);
                }
            }

            const initialSelectedValue = $('#klasifikasi').val();
            if (initialSelectedValue) {
                toggleRadioGroups(initialSelectedValue);
            }
            $('#klasifikasi').on('change', function() {
                const selectedValue = $(this).val();
                toggleRadioGroups(selectedValue);
            });

            // Event listener untuk submit form pemeliharaan preventif
            $('#formJadwalPemeliharaan').on('submit', function(e) {
                e.preventDefault();

                // Serialize semua data form menjadi string URL-encoded
                const formData = new FormData(this)

                // Lakukan permintaan Ajax POST ke endpoint Laravel
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.aset.pemeliharaan.scheduleStore', $id) }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#add-schedule').modal('hide');
                        $('#tableJadwalPemeliharaan').DataTable().ajax.reload();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        })
                    },
                    error: function(xhr) {
                        // if (xhr.responseJSON?.message === 'The name has already been taken.') {
                        //     $('#error-name').text('');
                        //     $('#error-frequency').text('');
                        //     $('#error-start').text('');
                        //     $('#error-end').text('');
                        //     $('#error-reminder').text('');
                        //     Swal.fire({
                        //         icon: 'info',
                        //         title: 'Gagal',
                        //         text: 'Error 422: Jadwal pemeliharaan ini sudah ada.',
                        //     });
                        // } else if (xhr.status === 422) {
                        //     Swal.fire({
                        //         icon: 'info',
                        //         title: 'Gagal',
                        //         text: 'Error ' + xhr.status + ': ' + (xhr.responseJSON.message || 'Validasi gagal. Periksa kembali input Anda.'),
                        //     });
                        //     $.each(xhr.responseJSON.errors, function(key, value) {
                        //         $(`#error-${key}`).text(value[0]);
                        //     });
                        // } else if (xhr.status === 500) {
                        //     Swal.fire({
                        //         icon: 'error',
                        //         title: 'Gagal',
                        //         text: 'Terjadi kesalahan pada server.',
                        //     });
                        // } else {
                        //     Swal.fire({
                        //         icon: 'error',
                        //         title: 'Gagal',
                        //         text: 'Terjadi kesalahan yang tidak diketahui.',
                        //     });
                        // }
                        const res = xhr.responseJSON;

                        // Reset pesan error text
                        $('.text-danger').text('');

                        if (xhr.status === 422) {
                            let errorMsg = res?.message || 'Data tidak valid';

                            if (res?.message === 'The name has already been taken.') {
                                errorMsg = 'Jadwal pemeliharaan ini sudah ada.';
                            }

                            Swal.fire({
                                icon: 'warning',
                                title: 'Perhatian',
                                text: errorMsg,
                            });

                            // Loop error validasi jika ada
                            if (res?.errors) {
                                $.each(res.errors, function(key, value) {
                                    $(`#error-${key}`).text(value[0]);
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan Sistem',
                                text: xhr.status === 500 ? 'Terjadi kesalahan pada server.' : 'Terjadi kesalahan yang tidak diketahui.',
                            });
                        }
                    },
                });
            });

            /**
             * Disable or enable the start date input field.
             * @param {boolean} disable - True to disable, false to enable.
             */
            // function toggleDate(disable) {
            //     $('#start').prop('disabled', disable)
            // }

            // // Disable the start input field by default
            // toggleDate(true)

            // // Listen for changes to the frequency select dropdown
            // $('#frequency').on('change', function() {
            //     const val = parseInt($(this).val());
            //     const now = new Date();

            //     // Enable the start input field
            //     toggleDate(false)

            //     // Set the start input field to today's date
            //     $('#start').val(now.toISOString().split('T')[0]);

            //     // Calculate the end date based on the selected frequency
            //     const futureDate = new Date(now);
            //     futureDate.setMonth(futureDate.getMonth() + val);

            //     // Set the end input field to the calculated date
            //     $('#end').val(futureDate.toISOString().split('T')[0]);
            // });

            // // Listen for changes to the start input field
            // $('#start').on('change', function() {
            //     const val = new Date($(this).val());

            //     // Calculate the end date based on the selected frequency
            //     const futureDate = new Date(val);
            //     futureDate.setMonth(val.getMonth() + parseInt($('#frequency').val()));

            //     // Set the end input field to the calculated date
            //     $('#end').val(futureDate.toISOString().split('T')[0]);
            // });
        });
    </script>
@endsection
