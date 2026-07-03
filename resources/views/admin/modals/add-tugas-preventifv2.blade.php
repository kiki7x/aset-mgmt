<div class="modal fade" id="add-tugas-preventifv2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="add-tugas-preventifv2-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-tugas-preventifv2-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTugasPreventifV2" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="name" id="v2tl_name">
                    <input type="hidden" name="period" id="v2tl_period">
                    <input type="hidden" name="future_period" id="v2tl_future_period">
                    <div class="form-group">
                        <label for="v2tl_attachment_link">Link Bukti Dukung <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="v2tl_attachment_link" name="attachment_link" required>
                        <small class="form-text text-muted">Masukkan link google drive</small>
                        <span id="error-v2tl_attachment_link" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="v2tl_cost">Biaya <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="v2tl_cost" name="cost" placeholder="Rp 0" required>
                        <span id="error-v2tl_cost" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="v2tl_notes">Catatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="4" id="v2tl_notes" name="notes" required></textarea>
                        <span id="error-v2tl_notes" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="v2tl_checkbox" name="confirmed" value="1" required>
                            <label for="v2tl_checkbox" class="custom-control-label font-weight-normal">
                                Saya telah menyelesaikan tugas ini. Periode pemeliharaan berikutnya: <span id="v2tl_future_text" class="badge badge-info"></span>
                                <span class="text-danger">*</span>
                            </label>
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
    $('#v2tl_cost').on('input', function() {
        var value = $(this).val();
        value = value.replace(/\D/g, '');
        if (value) {
            value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        }
        $(this).val(value);
    });

    function showModalAddPreventifV2(schedule_id) {
        $('#formTugasPreventifV2')[0].reset();
        $('.text-danger').text('');
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{ route('admin.aset.pemeliharaan.preventifAdd', ':id') }}".replace(':id', schedule_id),
            type: "GET",
            dataType: "json",
            success: function(data) {
                let m = $('#add-tugas-preventifv2');
                m.find('#add-tugas-preventifv2-label').html(
                    'Tindak lanjut Pemeliharaan Preventif untuk: ' +
                    '<span class="badge badge-info">' + data.maintenance_schedule.name + '</span>' +
                    '<span class="font-weight-bold"> ' + data.asset.name + '</span>' +
                    ' periode: <span class="badge badge-info">' + moment(data.maintenance_schedule.end).format('DD MMM YYYY') + '</span>'
                );
                m.find('#v2tl_name').val(data.maintenance_schedule.name);
                m.find('#v2tl_period').val(data.maintenance_schedule.end);

                const frequency = parseInt(data.maintenance_schedule.frequency);
                const futureDate = new Date(data.maintenance_schedule.end);
                const originalDay = futureDate.getDate();
                futureDate.setMonth(futureDate.getMonth() + frequency);
                if (futureDate.getDate() !== originalDay) {
                    futureDate.setDate(0);
                }
                m.find('#v2tl_future_period').val(moment(futureDate).format('YYYY-MM-DD'));
                m.find('#v2tl_future_text').text(moment(futureDate).format('DD MMM YYYY'));

                m.data('schedule-id', schedule_id);
                m.modal('show');
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memuat data. Silakan coba lagi.',
                });
            }
        });
    }

    $(document).ready(function() {
        $('#formTugasPreventifV2').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const scheduleId = $('#add-tugas-preventifv2').data('schedule-id');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('admin.aset.pemeliharaan.preventifStore', ['id' => ':id']) }}".replace(':id', scheduleId),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#add-tugas-preventifv2').modal('hide');
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
                        let errorMsg = res?.message || 'Validasi gagal';

                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: errorMsg,
                        });

                        if (res?.errors) {
                            $.each(res.errors, function(key, value) {
                                $(`#error-v2tl_${key}`).text(value[0]);
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
