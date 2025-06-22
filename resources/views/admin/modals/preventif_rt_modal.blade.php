@push('script-head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

<!-- Modal Pemeliharaan Preventif -->
<div class="modal fade" id="modalJadwalPemeliharaan" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalJadwalPemeliharaanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalJadwalPemeliharaanLabel">Jadwalkan Pemeliharaan Preventif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="formJadwalPemeliharaan">
                    {{-- Nama Barang & Hidden Input --}}
                    <div class="form-group">
                        <p class="h5">{{ $asset->tag }} - {{ $asset->name }}</p>
                        <input type="text" class="form-control d-none" id="asset_id" name="asset_id"
                            value="{{ $asset->id }}">
                        <input type="text" class="form-control d-none" id="status" name="status" value="active">
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
                        <label class="text-primary font-weight-normal">Detail Pemeliharaan TIK: <span
                                class="text-danger">*</span></label>
                        <div class="form-group">
                            <label>Tugas:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="name" value="Cek Kebersihan">
                                <label class="form-check-label" for="cek_kebersihan">1. Cek Kebersihan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="name" value="Cek Fungsi">
                                <label class="form-check-label" for="cek_fungsi">2. Cek Fungsi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="name" value="Cek Kondisi">
                                <label class="form-check-label" for="cek_kondisi">3. Cek Kondisi</label>
                            </div>
                        </div>
                    </div>

                    <div id="radioKendaraan" class="form-group border p-3 bg-light">
                        <label for="radioKendaraan" class="text-primary font-weight-normal">Detail Pemeliharaan
                            Kendaraan: <span class="text-danger">*</span></label>
                        <p class="text-muted small">Pilih tugas pemeliharaan yang relevan.</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="name" value="Pajak STNK">
                            <label class="form-check-label" for="pajak_stnk">1. Pajak STNK</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="name" value="Tune Up">
                            <label class="form-check-label" for="tune_up">2. Tune Up</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="name" value="Pelumasan">
                            <label class="form-check-label" for="pelumasan">3. Pelumasan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="name" value="Cek Radiator">
                            <label class="form-check-label" for="inspeksi_radiator">4. Inspeksi Radiator</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="name" value="Cek Mesin">
                            <label class="form-check-label" for="inspeksi_mesin">5. Inspeksi Mesin</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="name" value="Cek AC">
                            <label class="form-check-label" for="inspeksi_ac">6. Inspeksi AC</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="name" value="Cek Ban">
                            <label class="form-check-label" for="inspeksi_ban">7. Inspeksi Ban</label>
                        </div>
                    </div>

                    <div id="radioMesinElektronik" class="form-group p-3 border rounded mb-3 bg-light">
                        <label class="text-primary font-weight-normal">Detail Pemeliharaan Elektronik: <span
                                class="text-danger">*</span></label>
                        <div class="form-group">
                            <label>Tugas:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="name"
                                    value="Cek Kebersihan">
                                <label class="form-check-label" for="cek_kebersihan">1. Cek Kebersihan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="name" value="Cek Fungsi">
                                <label class="form-check-label" for="cek_fungsi">2. Cek Fungsi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="name" value="Cek Kondisi">
                                <label class="form-check-label" for="cek_kondisi">3. Cek Kondisi</label>
                            </div>
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
                    </div>
                    <!-- Tanggal Mulai -->
                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai <span class="text-danger">*</span></label>
                        <div>
                            <input id="start_date" width="276" type="text" class="form-control"
                                name="start_date" placeholder="dd/mm/yyyy" />
                        </div>
                    </div>
                    <!-- Tanggal Selanjutnya -->
                    <div class="form-group">
                        <label for="next_date">Tanggal Pemeliharaan Selanjutnya</label>
                        <div>
                            <input id="next_date" width="276" type="text" class="form-control"
                                name="next_date" placeholder="dd/mm/yyyy" readonly />
                        </div>
                        @error('next_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\JadwalPemeliharaanRequest', '#formJadwalPemeliharaan') !!}

    <script>
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
                    url: "{{ route('admin.asetrt.pemeliharaan.preventifStore', $id) }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modalJadwalPemeliharaan').modal('hide');
                        $('#tableJadwalPemeliharaan').DataTable().ajax.reload();

                        Swal.fire({
                            title: 'Berhasil',
                            text: response.message,
                            icon: 'success',
                        })
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.responseText);
                    }
                });
            });

            function toggleDate(disable) {
                $('#start_date').prop('disabled', disable)
            }

            toggleDate(true)

            $('#frequency').on('change', function() {
                const val = parseInt($(this).val());
                const now = new Date();

                toggleDate(false)

                $('#start_date').val(now.toISOString().split('T')[0]);

                const futureDate = new Date(now);

                futureDate.setMonth(futureDate.getMonth() + val);

                $('#next_date').val(futureDate.toISOString().split('T')[0]);
            });

            $('#start_date').on('change', function() {
                const val = new Date($(this).val());

                const futureDate = new Date(val);
                futureDate.setMonth(val.getMonth() + parseInt($('#frequency').val()));

                $('#next_date').val(futureDate.toISOString().split('T')[0]);
            });
        });
    </script>
@endsection
