<div class="modal fade" data-backdrop="static" role="dialog" id="create-issues">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Penugasan</h4>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="row form-group">
                        <!-- Asset Name -->
                        <div class="form-group col-md-8">
                            <label for="name">Nama Penugasan <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Contoh: 'Pemeriksaan berkala Komputer/Kendaraan Roda 4'">
                            @error('form.name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Tipe -->
                        <div class="form-group col-md-4">
                            <div>
                                <label for="issuetype">Tipe <span class="text-danger">*</span></label>
                                <select name="issuetype" id="issuetype" class="form-control select2" for="issuetype">
                                    <option name="None" id="None" value="">None</option>
                                    <option name="Task" id="Task" data-icon="fa-square-check fa-fw text-blue" value="Task">Tugas</option>
                                    <option name="Fix" id="Fix" data-icon="fa-minus-square fa-fw text-yellow" value="Fix">Perbaikan</option>
                                    <option name="Bug" id="Bug" data-icon="fa-bug fa-fw text-red" value="Bug">Bug (Celah)</option>
                                    <option name="Improvement" id="Improvement" data-icon="fa-external-link fa-fw text-teal" value="Improvement">Peningkatan</option>
                                    <option name="New_feature" id="New Feature" data-icon="fa-plus-square fa-fw text-green" value="New Feature">Fitur Baru</option>
                                    <option name="Story" id="Story" data-icon="fa-circle fa-fw text-red" value="Story">Story (Cerita)</option>
                                </select>
                            </div>
                            <span class="text-danger"></span>
                        </div>
                        <!-- Petugas -->
                        <div class="form-group col-md-4">
                            <div>
                                <label for="admin_id">Tugaskan kpd <span class="text-danger">*</span></label>
                                <select name="admin_id" id="admin_id" class="form-control select2">
                                    <option name="admin_id" id="admin_id" value="">None</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger"></span>
                        </div>

                        <!-- Aset -->
                        <div class="form-group col-md-4">
                            <label for="asset_id">Pilih Aset</label>
                            <select name="asset_id" id="asset_id" class="form-control select2tag" data-placeholder="None" multiple="multiple">
                                <option name="asset_id" value="">None</option>
                                @foreach ($assets as $asset)
                                    <option value="{{ $asset->id }}">{{ $asset->tag }} - {{ $asset->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger"></span>
                        </div>
                        <!-- Project -->
                        <div class="form-group col-md-4">
                            <div>
                                <label for="project_id">Project</label>
                                <select name="project_id" id="project_id" class="form-control select2">
                                    <option value="">None</option>
                                    @foreach ($projects as $pro)
                                        <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger"></span>
                        </div>
                        <!-- Status -->
                        <div class="form-group col-md-4">
                            <div>
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select name="status_id" id="status_id" class="form-control select2 @error('form.status_id') is-invalid @enderror" for="status_id">
                                    <option name="" value="">None</option>
                                    <option name="To Do" id="To Do" value="To Do" data-icon="fas fa-tag text-danger">Segera Kerjakan</option>
                                    <option name="In Progress" id="In Progress" value="In Progress" data-icon="fas fa-tag text-warning">Sedang Dikerjakan</option>
                                    <option name="In Review" id="In Review" value="In Review" data-icon="fas fa-tag text-info">Dalam Peninjauan</option>
                                    <option name="Done" id="Done" value="Done" data-icon="fas fa-tag text-secondary">Selesai</option>
                                </select>
                            </div>
                            <span class="text-danger"></span>
                        </div>
                        <!-- Skala Prioritas -->
                        <div class="form-group col-md-4">
                            <div>
                                <label for="priority">Prioritas <span class="text-danger">*</span></label>
                                <select name="priority" id="priority" class="form-control select2 @error('form.priority') is-invalid @enderror" for="priority">
                                    <option name="Pilih" id="Pilih" value="">None</option>
                                    <option name="Low" id="Low" value="Low" data-icon="fas fa-flag text-secondary">Rendah</option>
                                    <option name="Medium" id="Medium" value="Medium" data-icon="fas fa-flag text-warning">Sedang</option>
                                    <option name="High" id="High" value="High" data-icon="fas fa-flag text-danger">Tinggi</option>
                                </select>
                            </div>
                            <span class="text-danger"></span>
                        </div>
                        <!-- Batas Waktu -->
                        <div class="form-group col-md-4">
                            <label>Batas Waktu <span class="text-danger">*</span></label>
                            <div>
                                <input type="text" class="form-control" id="duedate" name="duedate" placeholder="Select date" />
                            </div>
                            <span class="text-danger"></span>
                        </div>
                        <!-- Description -->
                        <div class="form-group col-md-12">
                            <label for="description">Catatan</label>
                            <textarea name="description" id="description" class="form-control @error('form.description') is-invalid @enderror" rows="0" placeholder="Write description here..."></textarea>
                        </div>
                        <span class="text-danger"></span>
                    </div>
                    <span>tanda (<span class="text-danger">*</span>) wajib diisi</span>
                </div>
                <div class="modal-footer">
                    <!-- Submit Button -->
                    <button type="button" class="btn btn-info">Reset</button>
                    <button type="button" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

@push('script-foot2')
    <script>
        function openModalCreate() {
            $('#create-issues').modal('show');
        }

        $('#duedate').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
            orientation: "bottom auto",
            todayBtn: "linked",
        });

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Pilih",
                allowClear: true
            });

            $('.select2tag').select2({
                theme: 'bootstrap4',
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: "Pilih atau tambahkan aset",
                allowClear: true
            });
        });
    </script>
@endpush
