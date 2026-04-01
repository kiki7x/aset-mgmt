<!-- Modal Pemeliharaan Korektif -->
<div class="modal fade" id="add-korektif" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAddKorektifLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddKorektifLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAddKorektif" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Bagian 1: Identifikasi Aset --}}
                    {{-- <h4>1. Identifikasi Aset</h4> --}}
                    <h5 class="mb-3">Identifikasi Aset</h5>
                    {{-- Tag Aset --}}
                    <div class="form-group row">
                        <div class="col-3">Tag Aset</div>
                        <div class="col-1">:</div>
                        <div class="col-8">{{ $asset->tag }}</div>
                    </div>
                    {{-- Nama Aset --}}
                    <div class="form-group row">
                        <div class="col-3">Nama Aset</div>
                        <div class="col-1">:</div>
                        <div class="col-8">{{ $asset->name }}</div>
                    </div>
                    {{-- Lokasi Aset --}}
                    <div class="form-group row">
                        <div class="col-3">Lokasi Aset</div>
                        <div class="col-1">:</div>
                        <div class="col-8">{{ $asset->location->name }}</div>
                    </div>
                    <hr>
                    {{-- Bagian 2: Pelaporan Masalah --}}
                    <h5 class="mb-3">Tindakan Perbaikan</h5>
                    <!-- Judul Tindakan Korektif -->
                    <div class="form-group">
                        <label for="name">Judul Tindakan Korektif<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Contoh: 'Install software MS Office' / 'Perbaikan Kendaraan ABC atau Mesin XYZ'">
                        <span class="text-danger small" id="error-name"></span>
                    </div>
                    {{-- Deskripsi --}}
                    <div class="form-group">
                        <label for="description">Deskripsi Masalah <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Tipe -->
                        <div class="form-group col-md-6">
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
                            <span class="text-danger small" id="error-issuetype"></span>
                        </div>
                        <!-- Petugas -->
                        <div class="form-group col-md-6">
                            <label for="pic_id">Petugas <span class="text-danger">*</span></label>
                            <select name="pic_id" id="pic_id" class="form-control select2">
                                <option name="pic_id" id="pic_id" value="">None</option>
                                <option data-icon="fa-regular fa-circle-user" value="Nama"></option>
                                {{-- @foreach ($users as $user) --}}
                                {{-- @endforeach --}}
                            </select>
                            <span class="text-danger small" id="error-pic_id"></span>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Tanggal Mulai --}}
                        <div class="form-group col-md-6">
                            <label for="start_date">Tanggal Mulai Perbaikan</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                        </div>
                        {{-- Tanggal Selesai --}}
                        <div class="form-group col-md-6">
                            <label for="end_date">Tanggal Selesai Perbaikan</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                        </div>
                    </div>
                    {{-- Catatan Tindakan --}}
                    <div class="form-group">
                        <label for="actions_taken">Catatan Tindakan yang Dilakukan</label>
                        <textarea class="form-control" id="actions_taken" name="actions_taken" rows="4">{{ old('actions_taken') }}</textarea>
                    </div>
                    <div class="row">
                        {{-- Biaya --}}
                        <div class="form-group col-md-6">
                            <label for="cost">Biaya</label>
                            <input type="number" class="form-control" id="cost" name="cost" value="{{ old('cost') }}" min="0">
                        </div>
                        {{-- Bukti dukung --}}
                        <div class="form-group col-md-6">
                            <label for="attachment">Bukti dukung <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" class="form-control custom-file-input" id="attachment" name="attachment" accept=".jpg, .jpeg, .png, .heic, .heif, .pdf">
                                <label class="custom-file-label" for="attachment">Upload bukti dukung</label>
                                <small class="form-text text-muted">Format: JPG, JPEG, PNG, HEIC, HEIF, PDF (Max: 2MB)</small>
                            </div>
                            <span id="error-attachment" class="text-danger small"></span>
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button id="submitJadwalPemeliharaan" type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script-foot')
    <!-- ini untuk custom file input agar berfungsi reaktif -->
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        // Handle Pemeliharaan Korektif
        function showModalAddKorektif() {
            $('#modalAddKorektifLabel').text('Tambah Pemeliharaan Korektif');
            $('#add-korektif').modal('show');
        }
    </script>
@endpush
