<!-- Modal Edit Pemeliharaan Preventif -->
<div class="modal fade" id="edit-schedule" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalEditJadwalPemeliharaanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-schedule-label">Edit Jadwal Pemeliharaan Preventif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formEditJadwalPemeliharaan">
                    @csrf
                    @method('PATCH')
                    {{-- Nama Barang & Hidden Input --}}
                    <div class="form-group">
                        <p class="h5">{{ $asset->tag }} - {{ $asset->name }}</p>
                        <input type="text" class="form-control d-none" id="edit_id" name="id" value="">
                        <input type="text" class="form-control d-none" id="asset_id" name="asset_id" value="{{ $asset->id }}">
                        <input type="text" class="form-control d-none" id="status" name="status" value="aktif">
                    </div>

                    {{-- Klasifikasi Aset --}}
                    <div class="form-group">
                        <label for="klasifikasi">Klasifikasi</label>
                        <select class="form-control" id="edit_klasifikasi" name="klasifikasi" disabled>
                            <option value="1" @if ($asset->classification_id == 1) selected @endif>None</option>
                            <option value="2" @if ($asset->classification_id == 2) selected @endif>TIK</option>
                            <option value="3" @if ($asset->classification_id == 3) selected @endif>Kendaraan</option>
                            <option value="4" @if ($asset->classification_id == 4) selected @endif>Mesin/Elektronik
                            </option>
                        </select>
                    </div>

                    {{-- Nama Tugas --}}
                    <div class="form-group">
                        <label for="edit_name">Nama Tugas</label>
                        <input type="text" name="name" id="edit_name" class="form-control" value="" readonly>
                    </div>

                    {{-- Frekuensi Pemeliharaan --}}
                    <div class="form-group">
                        <label for="frequency">Frekuensi Pemeliharaan: <span class="text-danger">*</span></label>
                        <select class="form-control" id="edit_frequency" name="frequency">
                            <option value="">-- Pilih --</option>
                            <option value="3">Setiap 3 bulan sekali</option>
                            <option value="4">Setiap 4 bulan sekali</option>
                            <option value="6">Setiap 6 bulan sekali</option>
                            <option value="12">Setiap 12 bulan sekali</option>
                        </select>
                        <span class="text-danger small" id="error-frequency"></span>
                    </div>
                    <!-- Tanggal Mulai -->
                    <input type="hidden" id="edit_start" width="276" class="form-control" name="start" placeholder="yyyy-mm-dd" />
                    {{-- <div class="form-group">
                        <label for="start">Waktu Pemeliharaan <span class="text-danger">*</span></label>
                        <div>
                            <input id="edit_start" width="276" type="text" class="form-control" name="start" placeholder="yyyy-mm-dd" />
                        </div>
                        <span class="text-danger small" id="error-start"></span>
                    </div> --}}
                    <!-- Tanggal Selanjutnya -->
                    <div class="form-group">
                        <label for="end">Waktu Pemeliharaan</label>
                        <div>
                            <input id="edit_end" width="276" type="text" class="form-control" name="end" placeholder="DD MMM YYYY" />
                        </div>
                        <span class="text-danger small" id="error-end"></span>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button id="submitEditJadwalPemeliharaan" type="submit" class="btn btn-primary">Perbarui</button>
            </div>
            </form>
        </div>
    </div>
</div>

@push('script-foot')
<script>
    function showModalEditJadwalPemeliharaan(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.aset.pemeliharaan.scheduleEdit', ['id' => ':id']) }}".replace(':id', id),
            type: "GET",
            dataType: "json",
            beforeSend: function() {
                $('#edit-schedule-label').text('Edit Jadwal Pemeliharaan Preventif');
                $('#edit_id').val('');
                $('#edit_name').val('');
                $('#edit_frequency').val('');
                $('#edit_start').val('');
                $('#edit_end').val('');
                $('#edit_status').val('');
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal mengambil data jadwal pemeliharaan.',
                });
            },
            success: function(data) {
                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_frequency').val(data.frequency);
                // $('#edit_start').val(data.start ? new Date(data.start).toISOString().split('T')[0] : '');
                // $('#edit_end').val(data.end ? new Date(data.end).toISOString().split('T')[0] : '');
                $('#edit_start').val(data.end ? moment(data.end).format('DD-MM-YYYY') : '');
                $('#edit_end').val(data.end ? moment(data.end).format('DD MMM YYYY') : '');
                $('#edit_status').val(data.status);
            }
        });
        $('#edit-schedule').modal('show');
    }

    // Inisialisasi datepicker untuk input tanggal
    $('#edit_end').datepicker({
        format: "dd M yyyy",
        autoclose: true,
        todayHighlight: true,
        orientation: "auto",
        todayBtn: "linked",
    });

    // Pastikan dokumen siap sebelum menjalankan script jQuery
    $(document).ready(function() {

        function toggleRadioGroups(selectedValue) {
            // Sembunyikan semua bagian form detail terlebih dahulu
            $('#editRadioTik').hide();
            $('#editRadioKendaraan').hide();
            $('#editRadioMesinElektronik').hide();

            // Tampilkan bagian form yang sesuai berdasarkan pilihan
            if (selectedValue === '2') {
                $('#editRadioTik').removeClass('d-none').show();
                $('input[name="edit_name"]').prop('checked', false);
            } else if (selectedValue === '3') {
                $('#editRadioKendaraan').removeClass('d-none').show();
                $('input[name="edit_name"]').prop('checked', false);
            } else if (selectedValue === '4') {
                $('#editRadioMesinElektronik').removeClass('d-none').show();
                $('input[name="edit_name"]').prop('checked', false);
            }
        }

        const initialSelectedValue = $('#edit_klasifikasi').val();
        if (initialSelectedValue) {
            toggleRadioGroups(initialSelectedValue);
        }
        $('#edit_klasifikasi').on('change', function() {
            const selectedValue = $(this).val();
            toggleRadioGroups(selectedValue);
        });

        // Handle update
        $('#formEditJadwalPemeliharaan').on('submit', function(e) {
            e.preventDefault();

            // Serialize semua data form menjadi string URL-encoded
            const formData = new FormData(this)
            // Ambil ID dari input tersembunyi
            const id = $('#edit_id').val();

            // Lakukan permintaan Ajax POST ke endpoint Laravel
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.aset.pemeliharaan.scheduleUpdate', ['id' => ':id']) }}".replace(':id', id),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#modalEditJadwalPemeliharaan').modal('hide');
                    $('#tableJadwalPemeliharaan').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                    })
                    // tutup modal setelah submit
                    $('#edit-schedule').modal('hide');
                },
                error: function(xhr) {
                    if (xhr.responseJSON?.message === 'The name has already been taken.') {
                        $('#error-name').text('');
                        $('#error-frequency').text('');
                        $('#error-start').text('');
                        $('#error-end').text('');
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


        // Listen for changes to the frequency select dropdown
        // $('#edit_frequency').on('change', function() {
        //     const val = parseInt($(this).val());
        //     const now = new Date();

        //     // Set the start input field to today's date
        //     $('#edit_start').val(now.toISOString().split('T')[0]);

        //     // Calculate the end date based on the selected frequency
        //     const futureDate = new Date(now);
        //     futureDate.setMonth(futureDate.getMonth() + val);

        //     // Set the end input field to the calculated date
        //     $('#edit_end').val(futureDate.toISOString().split('T')[0]);
        // });

        // Listen for changes to the start input field
        // $('#edit_start').on('change', function() {
        //     const val = new Date($(this).val());

        //     // Calculate the end date based on the selected frequency
        //     const futureDate = new Date(val);
        //     futureDate.setMonth(val.getMonth() + parseInt($('#edit_frequency').val()));

        //     // Set the end input field to the calculated date
        //     $('#edit_end').val(futureDate.toISOString().split('T')[0]);
        // });
    });
</script>
@endpush
