<div wire:ignore.self class="modal fade" data-backdrop="static" role="dialog" id="modalCreate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Tambah Supplier</h4>
                <button type="button" class="close" wire:click="$dispatch('closeModalCreate')" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form wire:submit.prevent="store">
                <div class="modal-body">
                    <div class="row form-group">
                        <!-- Asset Name -->
                        <div class="form-group col-md-4">
                            <label for="name">Nama <span class="text-danger">*</span></label>
                            <input wire:model="form.name" type="text" name="name" class="form-control @error('form.name') is-invalid @enderror" id="name" placeholder="Name">
                            @error('form.name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-8">
                            <label for="address">Alamat <span class="text-danger">*</span></label>
                            <input wire:model="form.address" type="text" name="address" class="form-control @error('form.address') is-invalid @enderror" id="address" placeholder="Alamat">
                            @error('form.address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contactname">Nama Contact <span class="text-danger">*</span></label>
                            <input wire:model="form.contactname" type="text" name="contactname" class="form-control @error('form.contactname') is-invalid @enderror" id="contactname" placeholder="Nama Contact">
                            @error('form.contactname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phone">Phone <span class="text-danger">*</span></label>
                            <input wire:model="form.phone" type="text" name="phone" class="form-control @error('form.phone') is-invalid @enderror" id="phone" placeholder="Phone">
                            @error('form.phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input wire:model="form.email" type="email" name="email" class="form-control @error('form.email') is-invalid @enderror" id="email" placeholder="Email">
                            @error('form.email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label for="notes">Notes <span class="text-danger">*</span></label>
                            <input wire:model="form.notes" type="text" name="notes" class="form-control @error('form.notes') is-invalid @enderror" id="notes" placeholder="Notes">
                            @error('form.notes')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
                function reinitSelect2() {
                    // $('.select2').select2('destroy').select2({
                    $('.select2').select2({
                        theme: 'bootstrap4',
                        width: '100%'
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
                        placeholder: 'Pilih.../tambahkan',
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
