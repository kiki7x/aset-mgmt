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
                    {{-- Nama Bukti dukung --}}
                    <!-- <div class="form-group">
                        <label for="attachment_name">Nama Bukti dukung <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="attachment_name" name="attachment_name">
                        <span id="error-attachment_name" class="text-danger small"></span>
                    </div> -->
                    {{-- Bukti dukung --}}
                    <div class="form-group">
                        <label for="attachment_link">Link Bukti dukung <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="attachment_link" name="attachment_link">
                        <small class="form-text text-muted">Masukkan link google drive</small>
                        <span id="error-attachment_link" class="text-danger small"></span>
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
                    {{-- Periode berjalan--}}
                    <div class="form-group">
                        <input type="hidden" id="period" name="period" value="">
                        <span id="error-period" class="text-danger small"></span>
                    </div>
                    {{-- Periode selanjutnya --}}
                    <div class="form-group">
                        <label for="future_period">Periode Selanjutnya</label>
                        <input type="hidden" class="form-control" id="future_period" name="future_period" value="">
                    </div>

                    {{-- Checkbox --}}
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" name="name" value="" required>
                            <label for="customCheckbox1" class="custom-control-label font-weight-normal">Saya telah menyelesaikan tugas pemeliharaan ini, periode pemeliharaan berikutnya akan diset pada : <span id="checkbox_future_period"></span> <span
                                    class="text-danger">*</span></label>
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
    // $(function() {
    //     bsCustomFileInput.init();
    // });
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
            url: "{{ route('admin.aset.pemeliharaan.preventifAdd', ['id' => ':id']) }}".replace(':id', id),
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

                const frequency = parseInt(data.maintenance_schedule.frequency);
                const futureDate = new Date(data.maintenance_schedule.next_date);
                const originalDay = futureDate.getDate();
                // tambahkan bulan
                futureDate.setMonth(futureDate.getMonth() + frequency);
                // Cek apakah tanggalnya "tumpah" (overflow) Jika tanggal di futureDate tidak sama dengan originalDay, artinya kita masuk ke bulan berikutnya lagi.
                if (futureDate.getDate() !== originalDay) {
                    // Set ke tanggal 0 dari bulan hasil (ini akan memberikan hari terakhir bulan sebelumnya)
                    futureDate.setDate(0);
                }
                $('#formAddTugasPreventif input[name="future_period"]').val(futureDate.toISOString().split('T')[0]); // Set nilai periode selanjutnya dalam format YYYY-MM-DD
                $('#checkbox_future_period').html('<span class="badge badge-info">' + moment(futureDate).format('ll') + '</span>');

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
        // console.log(formData.get('attachment_link'));
        e.preventDefault();
        var formData = new FormData(this);
        var scheduleId = $('#add-tugas-preventif').data('schedule-id'); // Ganti dengan ID jadwal yang sesuai
        var assetId = "{{ $asset->id }}"; // Ganti dengan ID aset yang sesuai
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('admin.aset.pemeliharaan.preventifStore', ['id' => ':id']) }}".replace(':id', scheduleId),
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
                    $('#tableJadwalPemeliharaan').DataTable().ajax.reload();
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $('#error-attachment_name').text(errors.attachment_name ? errors.attachment_name[0] : '');
                    $('#error-attachment_link').text(errors.attachment_link ? errors.attachment_link[0] : '');
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