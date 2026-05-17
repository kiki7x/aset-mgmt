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
                <form action="" id="formJadwalPemeliharaan" method="POST">
                    @csrf
                    <h5 class="text-left">1. Pilih aset</h5>
                    {{-- Pilih klasifikasi --}}
                    <div class="form-group">
                        <label for="klasifikasi-select">Klasifikasi: <span class="text-danger">*</span></label>
                        <select class="form-control" id="klasifikasi-select" name="">
                            <option value="">-- Pilih --</option>
                            <option value="2">TIK</option>
                            <option value="3">Kendaraan</option>
                            <option value="4">Mesin/Elektronik</option>
                        </select>
                        <span class="text-danger small" id="error-klasifikasi"></span>
                    </div>


                    {{-- Pilih category aset, dinamiskan dengan pilihan radio button yang muncul sesuai klasifikasi yang dipilih, jika klasifikasi tidak dipilih maka pilihan radio button tidak muncul --}}
                    <div class="form-group" id="category" style="display: none;">
                        <label for="category-select">Kategori Aset: <span class="text-danger">*</span></label>
                        <select class="form-control" id="category-select" name="">
                            <option value="">-- Pilih --</option>
                        </select>
                        <span class="text-danger small" id="error-category"></span>
                    </div>

                    {{-- Pilih Aset, dinamiskan dengan pilihan radio button yang muncul sesuai kategori aset yang dipilih, jika kategori aset tidak dipilih maka pilihan radio button tidak muncul --}}
                    <div class="form-group" id="asset" style="display: none;">
                        <label for="asset-select">Aset: <span class="text-danger">*</span></label>
                        <select class="form-control" id="asset-select" name="asset">
                            <option value="">-- Pilih --</option>
                        </select>
                        <span class="text-danger small" id="error-asset"></span>
                    </div>

                    {{-- Pilih jenis tugas, khusus untuk klasifikasi Kendaraan ada pilihan Pajak STNK dan Service Berkala, selain Kendaraan ada pilihan Cek Kondisi & Service Berkala --}}
                    <div class="form-group" id="jenis-tugas" style="display: none;">
                        <label for="jenis-tugas-select">Jenis Tugas: <span class="text-danger">*</span></label>
                        <select class="form-control" id="jenis-tugas-select" name="name">
                            <option value="">-- Pilih --</option>
                        </select>
                        <span class="text-danger small" id="error-name"></span>
                    </div>

                    <hr>
                    <h5 class="text-left">2. Tentukan jadwal pemeliharaan</h5>

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
                    <!-- Tanggal Selanjutnya -->
                    <div class="form-group">
                        <label for="end">Waktu Pemeliharaan</label>
                        <div>
                            <input id="end" width="276" type="text" class="form-control" name="end" readonly />
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button id="submitJadwalPemeliharaan" type="submit" class="btn btn-success">Jadwalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script-foot')
    <script>
        // Tampilkan modal add jadwal dan ambil data klasifikasi, kategori, dan list aset untuk dropdown
        function showModalAddJadwal(clickedDate) {
            $('#add-schedule-label').html('Setup Jadwal Pemeliharaan pada: ' + '<span class="badge badge-success">' + moment(clickedDate).format('DD MMM YYYY') + '</span>'); // Set judul modal dengan tanggal yang diklik
            $('#formJadwalPemeliharaan')[0].reset();
            $('#add-schedule').modal('show');
            // moment.locale('en');
            $('#end').val(moment(clickedDate).format('DD MMMM YYYY'));
        }

        $('#klasifikasi-select').on('change', function() {
            const klasifikasi = $(this).val();
            const categoryWrapper = $('#category');;
            const categorySelect = $('#category-select');
            const assetWrapper = $('#asset');
            const assetSelect = $('#asset-select');
            const jenisTugasWrapper = $('#jenis-tugas');
            const jenisTugasSelect = $('#jenis-tugas-select');

            if (klasifikasi === '2') { // TIK
                // jenisTugasWrapper.show();
                // jenisTugasSelect.append('<option value="Cek Kondisi & Service Berkala">Cek Kondisi & Service Berkala</option>');
                // categoryAsetSelect.show();
                fetchCategoryAssets(klasifikasi); // Panggil fungsi untuk mengambil kategori aset TIK
            } else if (klasifikasi === '3') { // Kendaraan
                // jenisTugasWrapper.show();
                // jenisTugasSelect.append('<option value="Pajak STNK">Pajak STNK</option>');
                // jenisTugasSelect.append('<option value="Service Berkala">Service Berkala</option>');
                // categoryAsetSelect.show();
                fetchCategoryAssets(klasifikasi); // Panggil fungsi untuk mengambil kategori aset Kendaraan
            } else if (klasifikasi === '4') { // Mesin/Elektronik
                // jenisTugasWrapper.show();
                // jenisTugasSelect.append('<option value="Cek Kondisi & Service Berkala">Cek Kondisi & Service Berkala</option>');
                fetchCategoryAssets(klasifikasi); // Panggil fungsi untuk mengambil kategori aset Mesin/Elektronik
            } else {
                categoryWrapper.hide();
                categorySelect.empty().append('<option value="">-- Pilih --</option>');
                jenisTugasWrapper.hide();
                assetSelect.hide();
            }
        });

        // buat function ajax untuk mengambil kategori aset berdasarkan klasifikasi yang dipilih
        function fetchCategoryAssets(klasifikasi) {
            $.ajax({
                url: "{{ url('admin/pemeliharaan-preventif/get-categories') }}/" + klasifikasi,
                type: "GET",
                success: function(response) {
                    const categorySelect = $('#category-select');
                    const categoryWrapper = $('#category');
                    categorySelect.empty().append('<option value="">-- Pilih --</option>'); // Reset options

                    if (response.length > 0) {
                        response.forEach(function(category) {
                            categorySelect.append('<option value="' + category.id + '">' + category.name + '</option>');
                        });
                        categoryWrapper.show();
                    } else {
                        categoryWrapper.hide();
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching categories:', xhr);
                    categoryWrapper.hide();
                }
            });
        }

        $('#category-select').on('change', function() {
            const categoryId = $(this).val();
            const assetWrapper = $('#asset');
            const assetSelect = $('#asset-select');
            assetSelect.empty().append('<option value="">-- Pilih --</option>'); // Reset options

            if (categoryId) {
                $.ajax({
                    url: "{{ url('admin/pemeliharaan-preventif/get-assets') }}/" + categoryId,
                    type: "GET",
                    success: function(response) {
                        assetSelect.empty().append('<option value="">-- Pilih --</option>'); // Reset options
                        if (response.length > 0) {
                            response.forEach(function(asset) {
                                assetSelect.append('<option value="' + asset.id + '">' + asset.tag + ' - ' + asset.name + '</option>');
                            });
                            assetWrapper.show();
                        } else {
                            assetWrapper.hide();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching assets:', xhr);
                        assetWrapper.hide();
                    }
                });
            } else {
                assetWrapper.hide();
                assetSelect.empty().append('<option value="">-- Pilih --</option>');
            }
        });

        $('#asset-select').on('change', function() {
            const assetTag = $(this).val();
            const jenisTugasWrapper = $('#jenis-tugas');
            const jenisTugasSelect = $('#jenis-tugas-select');
            jenisTugasSelect.empty().append('<option value="">-- Pilih --</option>'); // Reset options

            if (assetTag) {
                // Tampilkan pilihan jenis tugas berdasarkan klasifikasi
                const klasifikasi = $('#klasifikasi-select').val();
                if (klasifikasi === '3') { // Kendaraan
                    jenisTugasSelect.append('<option value="Pajak STNK">Pajak STNK</option>');
                    jenisTugasSelect.append('<option value="Service Berkala">Service Berkala</option>');
                } else if (klasifikasi === '4') { // TIK dan Mesin/Elektronik
                    jenisTugasSelect.append('<option value="Cek Kondisi & Service Berkala">Cek Kondisi & Service Berkala</option>');
                } else if (klasifikasi === '2') {
                    jenisTugasSelect.append('<option value="Cek Kondisi & Service Berkala">Cek Kondisi & Service Berkala</option>');
                } else {
                    jenisTugasSelect.append('<option value="Cek Kondisi & Service Berkala">Cek Kondisi & Service Berkala</option>');
                }
                jenisTugasWrapper.show();
            } else {
                jenisTugasWrapper.hide();
                jenisTugasSelect.empty().append('<option value="">-- Pilih --</option>');
            }
        });

        // datepicker
        // $('#end').datepicker({
        //     format: "dd M yyyy",
        //     autoclose: true,
        //     todayHighlight: true,
        //     orientation: "auto",
        //     todayBtn: "linked",
        // });
    </script>
    <script>
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
                url: "{{ route('admin.pemeliharaan-preventif.scheduleStore') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                    }).then(() => {
                        $('#add-schedule').modal('hide');
                        window.calendar.refetchEvents();
                    })
                },
                error: function(xhr) {
                    const res = xhr.responseJSON;

                    // Reset pesan error text
                    $('.text-danger').text('');

                    if (xhr.status === 422) {
                        let errorMsg = res?.message || 'Data tidak valid';

                        if (res?.message === 'The name has already been taken.') {
                            // debug formData 
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
                            // text: xhr.status === 500 ? 'Terjadi kesalahan pada server.' : 'Terjadi kesalahan yang tidak diketahui.',
                            text: xhr.status === 500 ? xhr.responseJSON.message : 'Terjadi kesalahan yang tidak diketahui.',
                        });
                    }
                },
            });
        });
    </script>
@endpush
