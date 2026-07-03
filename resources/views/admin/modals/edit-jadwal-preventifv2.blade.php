<div class="modal fade" id="edit-schedulev2" data-backdrop="static" tabindex="-1" aria-labelledby="edit-schedulev2-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-schedulev2-label">Edit Jadwal Pemeliharaan Preventif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditJadwalV2">
                    @csrf
                    @method('PATCH')
                    {{-- Nama Barang & Hidden Input --}}
                    <div class="form-group">
                        <p class="h5">{{ $asset->tag }} - {{ $asset->name }}</p>
                        <input type="hidden" id="editv2_id" name="edit_id">
                        {{-- <input type="text" class="form-control d-none" id="asset_id" name="asset_id" value="{{ $asset->id }}"> --}}
                    </div>
                    <div class="form-group">
                        <label for="editv2_name">Nama Tugas</label>
                        <input type="text" id="editv2_name" name="edit_name" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editv2_frequency">Frekuensi Pemeliharaan <span class="text-danger">*</span></label>
                        <select class="form-control" id="editv2_frequency" name="edit_frequency" required>
                            <option value="">-- Pilih --</option>
                            <option value="3">Setiap 3 bulan sekali</option>
                            <option value="4">Setiap 4 bulan sekali</option>
                            <option value="6">Setiap 6 bulan sekali</option>
                            <option value="12">Setiap 12 bulan sekali</option>
                        </select>
                        <span class="text-danger small" id="error-editv2_frequency"></span>
                    </div>
                    <div class="form-group">
                        <label for="editv2_end">Periode Selanjutnya <span class="text-danger">*</span></label>
                        <input id="editv2_end" width="276" type="text" class="form-control" name="edit_end" placeholder="DD MMM YYYY" required>
                        <span class="text-danger small" id="error-editv2_end"></span>
                    </div>
                    <div class="form-group">
                        <label for="editv2_reminder">Pengingat (hari sebelum jatuh tempo)</label>
                        <input type="number" id="editv2_reminder" name="edit_reminder" class="form-control" min="0">
                        <span class="text-danger small" id="error-editv2_reminder"></span>
                    </div>
                    <div class="form-group">
                        <label for="editv2_status">Status</label>
                        <select class="form-control" id="editv2_status" name="edit_status">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script-foot')
    <script>
        $('#editv2_end').datepicker({
            format: "dd M yyyy",
            autoclose: true,
            todayHighlight: true,
            orientation: "auto",
            todayBtn: "linked",
        });

        function showModalEditJadwalV2(id) {
            $.ajax({
                url: "{{ route('admin.aset.pemeliharaan.scheduleEdit', ':id') }}".replace(':id', id),
                type: "GET",
                success: function(res) {
                    let m = $('#edit-schedulev2');
                    $('#edit-schedulev2-label').text('Edit Jadwal Pemeliharaan Preventif');
                    m.find('#editv2_id').val(res.id);
                    m.find('#editv2_name').val(res.name);
                    m.find('#editv2_frequency').val(res.frequency);
                    m.find('#editv2_end').val(res.end ? moment(res.end).format('DD MMM YYYY') : '');
                    m.find('#editv2_reminder').val(res.reminder);
                    m.find('#editv2_status').val(res.status);
                    m.modal('show');
                }
            });
        }

        $(document).ready(function() {
            $('#formEditJadwalV2').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const id = $('#editv2_id').val();

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
                        $('#edit-schedulev2').modal('hide');
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

                            Swal.fire({
                                icon: 'warning',
                                title: 'Perhatian',
                                text: errorMsg,
                            });

                            if (res?.errors) {
                                $.each(res.errors, function(key, value) {
                                    $(`#error-editv2_${key.replace('edit_', '')}`).text(value[0]);
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
