<div wire:ignore.self class="modal fade" data-backdrop="static" role="dialog" id="modalCreate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Penugasan</h4>
                <button type="button" class="close" wire:click="$dispatch('closeModalCreate')" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form wire:submit.prevent="store">
                <div class="modal-body">
                    <div class="row form-group">
                        <!-- Asset Name -->
                        <div class="form-group col-md-8">
                            <label for="name">Nama Penugasan <span class="text-danger">*</span></label>
                            <input wire:model="form.name" type="text" name="name" class="form-control @error('form.name') is-invalid @enderror" id="name" placeholder="Contoh: 'Pemeriksaan berkala Komputer/Kendaraan Roda 4'">
                            @error('form.name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Tipe -->
                        <div class="form-group col-md-4">
                            <div x-data="{
                                selectedType: @entangle('form.issuetype'),
                                initType() {
                                    // Inisialisasi Select2 menggunakan ID
                                    $(this.$refs.selecttype).on('change', (e) => {
                                        // singkronisasi perubahan ke alpinejs
                                        this.selectedType = $(e.target).val();
                                    });
                                }
                            }" x-init="initType()">
                                <label for="issuetype">Tipe <span class="text-danger">*</span></label>
                                <select wire:model="form.issuetype" x-ref="selecttype" name="issuetype" id="issuetype" class="form-control select2 @error('issuetype') is-invalid @enderror" for="issuetype">
                                    <option name="None" id="None" value="">None</option>
                                    <option name="Task" id="Task" data-icon="fa-square-check fa-fw text-blue" value="Task">Tugas</option>
                                    <option name="Fix" id="Fix" data-icon="fa-minus-square fa-fw text-yellow" value="Fix">Perbaikan</option>
                                    <option name="Bug" id="Bug" data-icon="fa-bug fa-fw text-red" value="Bug">Bug (Celah)</option>
                                    <option name="Improvement" id="Improvement" data-icon="fa-external-link fa-fw text-teal" value="Improvement">Peningkatan</option>
                                    <option name="New_feature" id="New Feature" data-icon="fa-plus-square fa-fw text-green" value="New Feature">Fitur Baru</option>
                                    <option name="Story" id="Story" data-icon="fa-circle fa-fw text-red" value="Story">Story (Cerita)</option>
                                </select>
                            </div>
                            @error('form.issuetype')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Petugas -->
                        <div class="form-group col-md-4">
                            <div x-data="{
                                selectedPetugas: @entangle('form.admin_id'),
                                initPetugas() {
                                    // Inisialisasi Select2 menggunakan ID
                                    $(this.$refs.selectpetugas).on('change', (e) => {
                                        // singkronisasi perubahan ke alpinejs
                                        this.selectedPetugas = $(e.target).val();
                                    });
                                }
                            }" x-init="initPetugas()">
                                <label for="admin_id">Tugaskan kpd <span class="text-danger">*</span></label>
                                <select wire:model="form.admin_id" x-ref="selectpetugas" name="admin_id" id="admin_id" class="form-control select2 @error('form.admin_id') is-invalid @enderror">
                                    <option name="admin_id" id="admin_id" value="">None</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('form.admin_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Aset -->
                        <div class="form-group col-md-4" x-data="{
                            open: false,
                            selectedAsset: @entangle('form.asset_id'),
                            initAsset() {
                                // inisialisasi select2
                                $(this.$refs.select2assets).on('select2:open', (e) => {
                                    if (!this.open) { // Periksa apakah assets sudah di-load
                                        {{-- $wire.call('loadAssets'); --}}
                                        this.$wire.call('loadAssets').then(() => {
                                            $(this.$refs.select2assets).select2('open'); // Tambahkan ini
                                        });
                                        this.open = true; // Tandai bahwa assets sudah di-load
                                    }
                                })
                                $(this.$refs.select2assets).on('change', (e) => {
                                    // singkronisasi perubahan ke alpinejs
                                    this.selectedAsset = $(e.target).val() ? $(e.target).val()[0] : null;
                                });
                            }
                        }" x-init="initAsset()">
                            <label for="asset_id">Pilih Aset</label>
                            <select wire:model="form.asset_id" x-on:click="open = true" x-show="open" x-ref="select2assets" name="asset_id" id="asset_id" class="form-control select2tag @error('form.asset_id') is-invalid @enderror" data-placeholder="None"
                                    multiple="multiple">
                                <option name="asset_id" value="">None</option>
                                @foreach ($assets as $asset)
                                    <option value="{{ $asset->id }}">{{ $asset->tag }} - {{ $asset->name }}</option>
                                @endforeach
                            </select>
                            @error('form.asset_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Project -->
                        <div class="form-group col-md-4">
                            <div x-data="{
                                selectedProject: @entangle('form.project_id'),
                                initProject() {
                                    // inisialisasi select2
                                    $(this.$refs.select2project).on('change', (e) => {
                                        // singkronisasi perubahan ke alpinejs
                                        this.selectedProject = $(e.target).val() ? $(e.target).val()[0] : null;
                                    });
                                }
                            }" x-init="initProject()">
                                <label for="project_id">Project</label>
                                <select wire:model="form.project_id" x-ref="select2project" name="project_id" id="project_id" class="form-control select2 @error('form.project_id') is-invalid @enderror">
                                    <option value="">None</option>
                                    @foreach ($projects as $pro)
                                        <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('form.project_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Status -->
                        <div class="form-group col-md-4">
                            <div x-data="{
                                selectedStatus: @entangle('form.status'),
                                initStatus() {
                                    // Inisialisasi Select2 menggunakan ID
                                    $(this.$refs.selectstatus).on('change', (e) => {
                                        // singkronisasi perubahan ke alpinejs
                                        this.selectedStatus = $(e.target).val();
                                    });
                                }
                            }" x-init="initStatus()">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select wire:model="form.status" x-ref="selectstatus" name="status_id" id="status_id" class="form-control select2 @error('form.status_id') is-invalid @enderror" for="status_id">
                                    <option name="" value="">None</option>
                                    <option name="To Do" id="To Do" value="To Do" data-icon="fas fa-tag text-danger">Segera Kerjakan</option>
                                    <option name="In Progress" id="In Progress" value="In Progress" data-icon="fas fa-tag text-warning">Sedang Dikerjakan</option>
                                    <option name="In Review" id="In Review" value="In Review" data-icon="fas fa-tag text-info">Dalam Peninjauan</option>
                                    <option name="Done" id="Done" value="Done" data-icon="fas fa-tag text-secondary">Selesai</option>
                                </select>
                            </div>
                            @error('form.status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Skala Prioritas -->
                        <div class="form-group col-md-4">
                            <div x-data="{
                                selectedPriority: @entangle('form.priority'),
                                initPriority() {
                                    // Inisialisasi Select2 menggunakan ID
                                    $(this.$refs.selectpriority).on('change', (e) => {
                                        // singkronisasi perubahan ke alpinejs
                                        this.selectedPriority = $(e.target).val();
                                    });
                                }
                            }" x-init="initPriority()">
                                <label for="priority">Prioritas <span class="text-danger">*</span></label>
                                <select wire:model="form.priority" x-ref="selectpriority" name="priority" id="priority" class="form-control select2 @error('form.priority') is-invalid @enderror" for="priority">
                                    <option name="Pilih" id="Pilih" value="">None</option>
                                    <option name="Low" id="Low" value="Low" data-icon="fas fa-flag text-secondary">Rendah</option>
                                    <option name="Medium" id="Medium" value="Medium" data-icon="fas fa-flag text-warning">Sedang</option>
                                    <option name="High" id="High" value="High" data-icon="fas fa-flag text-danger">Tinggi</option>
                                </select>
                            </div>
                            @error('form.priority')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Batas Waktu -->
                        <div class="form-group col-md-4">
                            <label for="duedate">Batas Waktu <span class="text-danger">*</span></label>
                            <div wire:ignore>
                                <x-flatpickr wire:model="form.duedate" name="duedate" id="purchaseDateInput" placeholder="Select date" />
                            </div>
                            @error('form.duedate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Description -->
                        <div class="form-group col-md-12">
                            <label for="description">Catatan</label>
                            <textarea wire:model="form.description" name="description" id="description" class="form-control @error('form.description') is-invalid @enderror" rows="0" placeholder="Write description here..."></textarea>
                        </div>
                        @error('form.description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <span>tanda (<span class="text-danger">*</span>) wajib diisi</span>
                </div>
                <div class="modal-footer">
                    <!-- Submit Button -->
                    <button wire:click="resetInput" type="button" class="btn btn-info">Reset</button>
                    <button wire:click="$dispatch('closeModalCreate')" type="button" class="btn btn-secondary">Batal</button>
                    <button wire:click="store" type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
</div>
@push('script')
    @script
        <script>
            document.addEventListener('livewire:initialized', function() {
                function formatText(icon) {
                    return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
                };

                function reinitSelect2() {
                    // $('.select2').select2('destroy').select2({
                    $('.select2').select2({
                        theme: 'bootstrap4',
                        width: '100%',
                        templateSelection: formatText,
                        templateResult: formatText,
                        dropdownParent: document.body
                    });
                }

                function reinitSelect2tag() {
                    // $('.select2tag').select2('destroy').select2({
                    $('.select2tag').select2({
                        theme: 'bootstrap4',
                        tags: true,
                        width: '100%',
                        multiple: true,
                        maximumSelectionLength: 1,
                        dropdownParent: document.body
                    });
                }


                Livewire.hook("morphed", () => {
                    reinitSelect2();
                    reinitSelect2tag();
                    $('#modalCreate').on('shown.bs.modal', function() {
                        reinitSelect2tag();
                    });
                })
            })
        </script>
    @endscript

    {{-- date-picker --}}
    <x-flatpickr::script />
    <!-- InputMask -->
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        // Event untuk membuka modalCreate
        window.addEventListener('showModalCreate', () => {
            $('#modalCreate').modal('show').modal({
                backdrop: 'static'
            })
        });
        // Event untuk menutup modalCreate
        window.addEventListener('hideModalCreate', () => {
            $('#modalCreate').modal('hide');
        });
    </script>
@endpush
