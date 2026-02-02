<!-- Modal Pemeliharaan Korektif -->
<div class="modal fade" id="add-korektif" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAddKorektifLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                    <div class="form-group">
                        <label for="asset_id">ID Aset <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="asset_id" name="asset_id" value="{{ old('asset_id') }}" required>
                        @error('asset_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="asset_name">Nama Aset <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="asset_name" name="asset_name" value="{{ old('asset_name') }}" required>
                        @error('asset_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="location">Lokasi Aset</label>
                        <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}">
                    </div>

                    {{-- Bagian 2: Pelaporan Masalah --}}
                    <h4>2. Pelaporan Masalah</h4>
                    <div class="form-group">
                        <label for="reported_date">Tanggal Pelaporan <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="reported_date" name="reported_date" value="{{ old('reported_date') }}" required>
                        @error('reported_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi Masalah <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="priority">Prioritas <span class="text-danger">*</span></label>
                        <select class="form-control" id="priority" name="priority" required>
                            <option value="">Pilih Prioritas</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                        @error('priority')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="reported_by">Dilaporkan Oleh <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="reported_by" name="reported_by" value="{{ old('reported_by', auth()->user()->name ?? '') }}" required>
                        @error('reported_by')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bagian 3: Penugasan dan Tindakan --}}
                    <h4>3. Penugasan dan Tindakan Perbaikan</h4>
                    <div class="form-group">
                        <label for="assigned_to">Ditugaskan Kepada</label>
                        <input type="text" class="form-control" id="assigned_to" name="assigned_to" value="{{ old('assigned_to') }}">
                    </div>
                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai Perbaikan</label>
                        <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="end_date">Tanggal Selesai Perbaikan</label>
                        <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="actions_taken">Tindakan yang Dilakukan</label>
                        <textarea class="form-control" id="actions_taken" name="actions_taken" rows="4">{{ old('actions_taken') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="parts_used">Bagian/Peralatan yang Digunakan</label>
                        <textarea class="form-control" id="parts_used" name="parts_used" rows="3">{{ old('parts_used') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="cost">Biaya (dalam Rupiah)</label>
                        <input type="number" class="form-control" id="cost" name="cost" value="{{ old('cost') }}" min="0">
                    </div>
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Terbuka</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="attachments">Lampiran (Gambar/Dokumen)</label>
                        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
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
