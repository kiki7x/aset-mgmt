<div class="modal fade" id="add-schedulev2" data-backdrop="static" tabindex="-1" aria-labelledby="add-schedulev2-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-schedulev2-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formJadwalV2">
                    {{-- Nama Barang & Hidden Input --}}
                    <div class="form-group">
                        <p class="h5">{{ $asset->tag }} - {{ $asset->name }}</p>
                        <input type="hidden" id="v2_name" name="name">
                        <input type="hidden" id="v2_start" name="start">
                    </div>
                    <div class="form-group">
                        <label for="v2_frequency">Frekuensi Pemeliharaan <span class="text-danger">*</span></label>
                        <select class="form-control" id="v2_frequency" name="frequency" required>
                            <option value="">-- Pilih --</option>
                            <option value="3">Setiap 3 bulan sekali</option>
                            <option value="4">Setiap 4 bulan sekali</option>
                            <option value="6">Setiap 6 bulan sekali</option>
                            <option value="12">Setiap 12 bulan sekali</option>
                        </select>
                        <span class="text-danger small" id="error-v2_frequency"></span>
                    </div>
                    <div class="form-group">
                        <label for="v2_end">Periode Selanjutnya <span class="text-danger">*</span></label>
                        <input id="v2_end" width="276" type="text" class="form-control" name="end" placeholder="DD MMM YYYY" required>
                        <span class="text-danger small" id="error-v2_end"></span>
                    </div>
                    <div class="form-group">
                        <label for="v2_reminder">Pengingat (hari sebelum jatuh tempo)</label>
                        <input type="number" id="v2_reminder" name="reminder" class="form-control" value="7" min="0">
                        <span class="text-danger small" id="error-v2_reminder"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Jadwalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script-foot')
    <script>
        $('#v2_end').datepicker({
            format: "dd M yyyy",
            autoclose: true,
            todayHighlight: true,
            orientation: "auto",
            todayBtn: "linked",
        });

        $('#v2_end').on('change', function() {
            $('#v2_start').val($(this).val());
        });

        function showModalAddJadwalV2(name) {
            $('#add-schedulev2-label').text('Setup Jadwal ' + name);
            $('#add-schedulev2').modal('show');
            $('#add-schedulev2').find('#v2_name').val(name);
        }

        $(document).ready(function() {
            $('#formJadwalV2').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.aset.pemeliharaan.scheduleStore', $asset->id) }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#add-schedulev2').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        $('.text-danger').text('');

                        if (xhr.status === 422) {
                            const res = xhr.responseJSON;
                            let errorMsg = res?.message || 'Data tidak valid';

                            if (res?.message === 'The name has already been taken.') {
                                errorMsg = 'Jadwal pemeliharaan ini sudah ada.';
                            }

                            Swal.fire({
                                icon: 'warning',
                                title: 'Perhatian',
                                text: errorMsg,
                            });

                            if (res?.errors) {
                                $.each(res.errors, function(key, value) {
                                    $(`#error-v2_${key}`).text(value[0]);
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
        });
    </script>
@endpush