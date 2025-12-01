<!-- Modal Pemeliharaan Preventif -->
<div class="modal fade" id="add-schedule" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalJadwalPemeliharaanLabel" aria-hidden="true">
    <div class="modal-dialog">
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
                    <!-- Tanggal Mulai -->
                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai <span class="text-danger">*</span></label>
                        <div>
                            <input id="start_date" width="276" type="text" class="form-control" name="start_date" placeholder="yyyy-mm-dd" />
                        </div>
                        <span class="text-danger small" id="error-start_date"></span>
                    </div>
                    <!-- Tanggal Selanjutnya -->
                    <div class="form-group">
                        <label for="next_date">Tanggal Pemeliharaan Selanjutnya</label>
                        <div>
                            <input id="next_date" width="276" type="text" class="form-control" name="next_date" placeholder="yyyy-mm-dd" readonly />
                        </div>
                        <span class="text-danger small" id="error-next_date"></span>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button id="submitJadwalPemeliharaan" type="submit" class="btn btn-primary">Jadwalkan</button>
            </div>
            </form>
        </div>
    </div>
</div>

@section('script-foot')
    {{-- Laravel javascript Validation --}}
    {{-- <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js') }}"></script> --}}
    {{-- {!! JsValidator::formRequest('App\Http\Requests\JadwalPemeliharaanRequest', '#formJadwalPemeliharaan') !!} --}}


    <script>
        function showModalAddJadwalPemeliharaan() {
            $('#add-schedule-label').text('Setup Jadwal Pemeliharaan');
            $('#formJadwalPemeliharaan')[0].reset();
            $('#add-schedule').modal('show');
        }
        $('#start_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true,
            orientation: "auto",
            todayBtn: "linked",
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
                    url: "{{ route('admin.asetrt.pemeliharaan.scheduleStore', $id) }}",
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
                        if (xhr.responseJSON?.message === 'The name has already been taken.') {
                            $('#error-name').text('');
                            $('#error-frequency').text('');
                            $('#error-start_date').text('');
                            $('#error-next_date').text('');
                            Swal.fire({
                                icon: 'info',
                                title: 'Gagal',
                                text: 'Jadwal pemeliharaan ini sudah ada.',
                            });
                        } else if (xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $(`#error-${key}`).text(value[0]);
                            });
                            // Swal.fire({
                            //     icon: 'warning',
                            //     title: 'Gagal',
                            //     text: 'Periksa kembali data yang dimasukkan.',
                            // });
                        }
                        return false;
                    }
                });
            });

            /**
             * Disable or enable the start_date input field.
             * @param {boolean} disable - True to disable, false to enable.
             */
            function toggleDate(disable) {
                $('#start_date').prop('disabled', disable)
            }

            // Disable the start_date input field by default
            toggleDate(true)

            // Listen for changes to the frequency select dropdown
            $('#frequency').on('change', function() {
                const val = parseInt($(this).val());
                const now = new Date();

                // Enable the start_date input field
                toggleDate(false)

                // Set the start_date input field to today's date
                $('#start_date').val(now.toISOString().split('T')[0]);

                // Calculate the next date based on the selected frequency
                const futureDate = new Date(now);
                futureDate.setMonth(futureDate.getMonth() + val);

                // Set the next_date input field to the calculated date
                $('#next_date').val(futureDate.toISOString().split('T')[0]);
            });

            // Listen for changes to the start_date input field
            $('#start_date').on('change', function() {
                const val = new Date($(this).val());

                // Calculate the next date based on the selected frequency
                const futureDate = new Date(val);
                futureDate.setMonth(val.getMonth() + parseInt($('#frequency').val()));

                // Set the next_date input field to the calculated date
                $('#next_date').val(futureDate.toISOString().split('T')[0]);
            });
        });
    </script>
@endsection
