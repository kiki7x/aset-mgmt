{{-- Modal Edit --}}
<div class="modal fade" data-backdrop="static" id="edit-pemeliharaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Pemeliharaan Korektif</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formEditPemeliharaan">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="mb-n1" for="edit-name">Judul Penugasan / Tindakan Korektif<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="edit-name" placeholder="Contoh: 'Install software MS Office' / 'Perbaikan Kendaraan ABC atau Mesin XYZ'">
                            <span class="text-danger small" id="error-edit-name"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <div>
                                <label class="mb-n1" for="edit-issuetype">Tipe <span class="text-danger">*</span></label>
                                <select name="issuetype" id="edit-issuetype" class="form-control select2-edit">
                                    <option value="">None</option>
                                    <option value="Tugas" data-icon="fa-regular fa-square-check fa-fw text-primary">Tugas</option>
                                    <option value="Perbaikan" data-icon="fa-solid fa-screwdriver-wrench fa-fw text-yellow">Perbaikan</option>
                                    <option value="Peningkatan" data-icon="fa-solid fa-arrow-up-right-dots fa-fw text-teal">Peningkatan</option>
                                    <option value="Celah" data-icon="fa-solid fa-bug fa-fw text-red">Bug (Celah)</option>
                                    <option value="Fitur Baru" data-icon="fa-regular fa-plus-square fa-fw text-green">Fitur Baru</option>
                                    <option value="Informasi" data-icon="fa-solid fa-circle-info fa-fw text-red">Informasi</option>
                                </select>
                            </div>
                            <span class="text-danger small" id="error-edit-issuetype"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <div>
                                <label class="mb-n1" for="edit-pic_id">Tugaskan kpd <span class="text-danger">*</span></label>
                                <select name="pic_id" id="edit-pic_id" class="form-control select2-edit">
                                    <option value="">None</option>
                                    @foreach ($users as $user)
                                        <option data-icon="fa-regular fa-circle-user" value="{{ $user->id }}">{{ $user->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger small" id="error-edit-pic_id"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="mb-n1" for="edit-asset_id">Pilih Aset Terkait</label>
                            <select name="asset_id" id="edit-asset_id" class="form-control select2tag-edit" multiple>
                                <option value="">None</option>
                                @foreach ($assets as $asset)
                                    <option value="{{ $asset->id }}">{{ $asset->tag }} - {{ $asset->name }} - ( SN: {{ $asset->serial }} )</option>
                                @endforeach
                            </select>
                            <span class="text-danger small" id="error-edit-asset_id"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <div>
                                <label class="mb-n1" for="edit-priority">Prioritas <span class="text-danger">*</span></label>
                                <select name="priority" id="edit-priority" class="form-control select2-edit">
                                    <option value="">None</option>
                                    <option value="Rendah" data-icon="fas fa-flag text-secondary">Rendah</option>
                                    <option value="Sedang" data-icon="fas fa-flag text-warning">Sedang</option>
                                    <option value="Tinggi" data-icon="fas fa-flag text-danger">Tinggi</option>
                                </select>
                            </div>
                            <span class="text-danger small" id="error-edit-priority"></span>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="mb-n1">Batas Waktu <span class="text-danger">*</span></label>
                            <div>
                                <input type="text" class="form-control" id="edit-duedate" name="duedate" placeholder="Select date" />
                            </div>
                            <span class="text-danger small" id="error-edit-duedate"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="mb-n1" for="edit-description">Deskripsi</label> <span class="text-muted font-italic">deskripsikan rincian perintah tugas</span>
                            <textarea name="description" id="edit-description" rows="4" class="form-control" placeholder="Write description here..."></textarea>
                            <span id="error-edit-description" class="text-danger small"></span>
                        </div>
                    </div>
                    <span class="text-muted font-italic">tanda (<span class="text-danger">*</span>) wajib diisi</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script-foot')
    <script>
        function showModalEditPemeliharaan(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.pemeliharaan-korektif.edit', ['id' => ':id']) }}".replace(':id', id),
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#formEditPemeliharaan')[0].reset();
                    $('.text-danger.small').text('');
                },
                success: function(data) {
                    $('#edit-pemeliharaan').modal('show').data('id', id);
                    $('.modal-title').text('Edit Pemeliharaan Korektif');
                    $('#edit-name').val(data.name);
                    $('#edit-issuetype').val(data.issuetype).trigger('change');
                    $('#edit-pic_id').val(data.pic_id).trigger('change');
                    $('#edit-asset_id').val([data.asset_id]).trigger('change');
                    $('#edit-priority').val(data.priority).trigger('change');
                    $('#edit-duedate').val(moment(data.duedate).format('DD MMM YYYY'));
                    $('#edit-description').val(data.description);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memuat data. Silakan coba lagi.',
                    });
                }
            })
        }

        $('#edit-duedate').datepicker({
            format: "dd M yyyy",
            autoclose: true,
            todayHighlight: true,
            orientation: "bottom auto",
            todayBtn: "linked",
        });

        $(document).ready(function() {
            function formatIcon(state) {
                if (!state.id) return state.text;
                var iconClass = $(state.element).data('icon');
                return $('<span><i class="' + iconClass + '"></i> ' + state.text + '</span>');
            }
            $('.select2-edit').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#edit-pemeliharaan'),
                width: '100%',
                templateResult: formatIcon,
                templateSelection: formatIcon,
                escapeMarkup: function(m) { return m; }
            });
            $('.select2tag-edit').select2({
                theme: 'bootstrap4',
                tags: true,
                dropdownParent: $('#edit-pemeliharaan'),
                width: '100%',
                maximumSelectionLength: 1,
            });
        });

        $('#formEditPemeliharaan').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit-pemeliharaan').data('id');
            var formData = new FormData(this);
            formData.append('_method', 'PUT');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.pemeliharaan-korektif.update', ['id' => ':id']) }}".replace(':id', id),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil diperbarui!',
                    }).then(() => {
                        $('#edit-pemeliharaan').modal('hide');
                        $('#formEditPemeliharaan')[0].reset();
                        $('.select2-edit, .select2tag-edit').val(null).trigger('change');
                        $('#tablePemeliharaan').DataTable().ajax.reload();
                        $('#tablePemeliharaanSelesai').DataTable().ajax.reload();
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#error-edit-' + key).text(value[0]);
                        });
                        const fields = ['name', 'issuetype', 'pic_id', 'asset_id', 'priority', 'duedate', 'description'];
                        fields.forEach(function(field) {
                            if (!errors[field]) {
                                $('#error-edit-' + field).text('');
                            }
                        });
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
