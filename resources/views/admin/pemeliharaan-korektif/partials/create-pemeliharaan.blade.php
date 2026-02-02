{{-- Modal Create --}}
<div class="modal fade" data-backdrop="static" id="add-pemeliharaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Pemeliharaan Korektif</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formAddPemeliharaan">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Asset Name -->
                        <div class="form-group col-md-12">
                            <label for="name">Judul Penugasan / Tindakan Korektif<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Contoh: 'Install software MS Office' / 'Perbaikan Kendaraan ABC atau Mesin XYZ'">
                            <span class="text-danger small" id="error-name"></span>
                        </div>

                        <!-- Tipe -->
                        <div class="form-group col-md-6">
                            <div>
                                <label for="issuetype">Tipe <span class="text-danger">*</span></label>
                                <select name="issuetype" id="issuetype" class="form-control select2" for="issuetype">
                                    <option name="None" id="None" value="">None</option>
                                    <option name="Tugas" id="Tugas" data-icon="fa-regular fa-square-check fa-fw text-primary" value="Tugas">Tugas</option>
                                    <option name="Perbaikan" id="Perbaikan" data-icon="fa-solid fa-screwdriver-wrench fa-fw text-yellow" value="Perbaikan">Perbaikan</option>
                                    <option name="Peningkatan" id="Peningkatan" data-icon="fa-solid fa-arrow-up-right-dots fa-fw text-teal" value="Peningkatan">Peningkatan</option>
                                    <option name="Celah" id="Celah" data-icon="fa-solid fa-bug fa-fw text-red" value="Celah">Bug (Celah)</option>
                                    <option name="Fitur Baru" id="Fitur Baru" data-icon="fa-regular fa-plus-square fa-fw text-green" value="Fitur Baru">Fitur Baru</option>
                                    <option name="Informasi" id="Informasi" data-icon="fa-solid fa-circle-info fa-fw text-red" value="Informasi">Informasi</option>
                                </select>
                            </div>
                            <span class="text-danger small" id="error-issuetype"></span>
                        </div>

                        <!-- Petugas -->
                        <div class="form-group col-md-6">
                            <div>
                                <label for="pic_id">Tugaskan kpd <span class="text-danger">*</span></label>
                                <select name="pic_id" id="pic_id" class="form-control select2">
                                    <option name="pic_id" id="pic_id" value="">None</option>
                                    @foreach ($users as $user)
                                        <option data-icon="fa-regular fa-circle-user" value="{{ $user->id }}">{{ $user->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger small" id="error-pic_id"></span>
                        </div>

                        <!-- Aset -->
                        <div class="form-group col-md-12">
                            <label for="asset_id">Pilih Aset Terkait</label>
                            <select name="asset_id" id="asset_id" class="form-control select2tag" multiple>
                                <option name="asset_id" value="">None</option>
                                @foreach ($assets as $asset)
                                    <option value="{{ $asset->id }}">{{ $asset->tag }} - {{ $asset->name }} - ( SN: {{ $asset->serial }} )</option>
                                @endforeach
                            </select>
                            <span class="text-danger small" id="error-asset_id"></span>
                        </div>

                        <!-- Project -->
                        {{-- <div class="form-group col-md-4">
                            <div>
                                <label for="project_id">Project</label>
                                <select name="project_id" id="project_id" class="form-control select2">
                                    <option value="">None</option>
                                    @foreach ($projects as $pro)
                                        <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger small" id="error-project_id"></span>
                        </div> --}}

                        <!-- Status -->
                        {{-- <div class="form-group col-md-4">
                            <div>
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control select2 @error('form.status') is-invalid @enderror" for="status">
                                    <option name="" value="">None</option>
                                    <option name="Segera Kerjakan" id="Segera Kerjakan" value="Segera Kerjakan" data-icon="fas fa-tag text-danger">Segera Kerjakan</option>
                                    <option name="Sedang Dikerjakan" id="Sedang Dikerjakan" value="Sedang Dikerjakan" data-icon="fas fa-tag text-warning">Sedang Dikerjakan</option>
                                    <option name="Dalam Tinjauan" id="Dalam Tinjauan" value="Dalam Tinjauan" data-icon="fas fa-tag text-info">Dalam Tinjauan</option>
                                    <option name="Selesai" id="Selesai" value="Selesai" data-icon="fas fa-tag text-secondary">Selesai</option>
                                </select>
                            </div>
                            <span class="text-danger small" id="error-status"></span>
                        </div> --}}
                        <div class="form-group col-md-12 d-none">
                            <input type="text" name="status" class="form-control" id="status" value="Segera Kerjakan">
                            <span class="text-danger small" id="error-status"></span>
                        </div>

                        <!-- Skala Prioritas -->
                        <div class="form-group col-md-6">
                            <div>
                                <label for="priority">Prioritas <span class="text-danger">*</span></label>
                                <select name="priority" id="priority" class="form-control select2 @error('form.priority') is-invalid @enderror" for="priority">
                                    <option name="Pilih" id="Pilih" value="">None</option>
                                    <option name="Rendah" id="Rendah" value="Rendah" data-icon="fas fa-flag text-secondary">Rendah</option>
                                    <option name="Sedang" id="Sedang" value="Sedang" data-icon="fas fa-flag text-warning">Sedang</option>
                                    <option name="Tinggi" id="Tinggi" value="Tinggi" data-icon="fas fa-flag text-danger">Tinggi</option>
                                </select>
                            </div>
                            <span class="text-danger small" id="error-priority"></span>
                        </div>

                        <!-- Batas Waktu -->
                        <div class="form-group col-md-6">
                            <label>Batas Waktu <span class="text-danger">*</span></label>
                            <div>
                                <input type="text" class="form-control" id="duedate" name="duedate" placeholder="Select date" />
                            </div>
                            <span class="text-danger small" id="error-duedate"></span>
                        </div>

                        <!-- Catatan -->
                        <div class="form-group col-md-12">
                            <label for="description">Deskripsi</label> <span class="text-muted font-italic">deskripsikan rincian perintah tugas</span>
                            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Write description here..."></textarea>
                            <span id="error-description" class="text-danger small"></span>
                        </div>

                        {{-- Hidden input created_by --}}
                        <div class="form-group col-md-12 d-none">
                            <input type="text" name="created_by" class="form-control" id="created_by" value="{{ auth()->user()->id }}">
                            <span class="text-danger small" id="error-created_by"></span>
                        </div>
                    </div>
                    <span class="text-muted font-italic">tanda (<span class="text-danger">*</span>) wajib diisi</span>
                </div>
                <div class="modal-footer">
                    <!-- Submit Button -->
                    <button type="button" class="btn btn-info">Reset</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script-foot')
    <script>
        function openModalCreate() {
            $('#add-pemeliharaan').modal('show');
        }

        $('#duedate').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true,
            orientation: "bottom auto",
            todayBtn: "linked",
        });
    </script>

    <script>
        // Select2 Initialization
        $(document).ready(function() {
            function formatIcon(state) {
                if (!state.id) {
                    return state.text;
                } // Jika placeholder

                // Ambil data-icon dari elemen <option>
                var iconClass = $(state.element).data('icon');

                // Buat struktur HTML dengan ikon
                var $state = $(
                    '<span><i class="' + iconClass + '"></i> ' + state.text + '</span>'
                );
                return $state;
            }
            $('.select2').select2({
                // theme: 'bootstrap4',
                // width: '100%',
                // placeholder: "Pilih",
                // allowClear: true
                theme: 'bootstrap4',
                dropdownParent: $('#add-pemeliharaan'),
                width: '100%',
                templateResult: formatIcon, // Untuk daftar dropdown
                templateSelection: formatIcon, // Untuk item yang terpilih
                escapeMarkup: function(m) {
                    return m;
                } // Penting agar HTML tidak di-escape
            });

            $('.select2tag').select2({
                // theme: 'bootstrap4',
                // tags: true,
                // tokenSeparators: [',', ' '],
                // placeholder: "Pilih atau tambahkan aset",
                // allowClear: true
                theme: 'bootstrap4',
                tags: true,
                dropdownParent: $('#add-pemeliharaan'),
                width: '100%',
                maximumSelectionLength: 1,
            });
        });
    </script>

    {{-- Handle Submit --}}
    <script>
        $('#formAddPemeliharaan').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.pemeliharaan.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil disimpan!',
                    }).then(() => {
                        $('#add-pemeliharaan').modal('hide');
                        $('#formAddPemeliharaan')[0].reset();
                        $('.select2, .select2tag').val(null).trigger('change');
                        $('#tablePemeliharaan').DataTable().ajax.reload();
                    });

                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $(`#error-${key}`).text(value[0]);
                        });
                        // jika tidak ada error pada field tertentu, kosongkan pesan errornya
                        const fields = ['name', 'issuetype', 'pic_id', 'asset_id', 'status', 'priority', 'duedate', 'description'];
                        fields.forEach(function(field) {
                            if (!errors[field]) {
                                $(`#error-${field}`).text('');
                            }
                        });
                    }
                }
            });
        });
    </script>
@endpush
