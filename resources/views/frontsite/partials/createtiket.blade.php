{{-- Modal Create --}}
<div class="modal fade" data-bs-backdrop="static" id="form-tiket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Form Service Desk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formCreateTicket" action="{{ route('servicedesk.store.public') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-body" id="modalCreateTicket">

                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label"><strong>Nama</strong></label>
                        <div class="col-9">
                            <input type="text" name="nama" id="ticket-nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label"><strong>Email</strong></label>
                        <div class="col-9">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label"><strong>Nomor WhatsApp</strong></label>
                        <div class="col-9">
                            <input type="text" name="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror" value="{{ old('whatsapp_number') }}" placeholder="contoh: 081234567890" required>
                            @error('whatsapp_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label"><strong>Judul</strong></label>
                        <div class="col-9">
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}">
                            @error('subject')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Jenis --}}
                    <fieldset class="form-group mb-3">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0"><strong>Jenis</strong></legend>
                            <div class="col-sm-9">

                                <div class="form-check-inline">
                                    <input class="form-check-input @error('issuetype') is-invalid @enderror" type="radio" name="issuetype" value="Keluhan" {{ old('issuetype') == 'Keluhan' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Keluhan
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <input class="form-check-input @error('issuetype') is-invalid @enderror" type="radio" name="issuetype" value="Permintaan" {{ old('issuetype') == 'Permintaan' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Permintaan
                                    </label>
                                </div>

                                @error('issuetype')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                    </fieldset>

                    {{-- Department --}}
                    <fieldset class="form-group mb-3">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0"><strong>Bidang</strong></legend>
                            <div class="col-sm-9">

                                <div class="form-check-inline">
                                    <input class="form-check-input @error('department') is-invalid @enderror" type="radio" name="department" value="TIK" {{ old('department') == 'TIK' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        TIK
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <input class="form-check-input @error('department') is-invalid @enderror" type="radio" name="department" value="Rumah Tangga" {{ old('department') == 'Rumah Tangga' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Rumah Tangga
                                    </label>
                                </div>

                                @error('department')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                    </fieldset>

                    {{-- Priority --}}
                    <fieldset class="form-group mb-3">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0"><strong>Urgensi / Prioritas</strong></legend>

                            <div class="col-sm-9">

                                <div class="form-check-inline">
                                    <input class="form-check-input @error('priority') is-invalid @enderror" type="radio" name="priority" value="Low" {{ old('priority') == 'Low' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Rendah
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <input class="form-check-input @error('priority') is-invalid @enderror" type="radio" name="priority" value="Medium" {{ old('priority') == 'Medium' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Sedang
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <input class="form-check-input @error('priority') is-invalid @enderror" type="radio" name="priority" value="High" {{ old('priority') == 'High' ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Tinggi
                                    </label>
                                </div>

                                @error('priority')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                    </fieldset>

                    {{-- Deskripsi --}}
                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label"><strong>Deskripsi</strong></label>
                        <div class="col-9">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Attachment --}}
                    <div class="form-group row mb-3">

                        <label class="col-3 col-form-label">
                            <strong>Lampiran</strong>
                        </label>

                        <div class="col-9">

                            <input type="file" name="attachments" class="form-control @error('attachments') is-invalid @enderror" accept="image/*">

                            @error('attachments')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                        </div>

                    </div>

                    {{-- CAPTCHA --}}
                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label">
                            <strong>Keamanan</strong>
                        </label>
                        <div class="col-9">
                            <div class="d-flex align-items-center mb-2">
                                <img id="ticket-captcha-image" src="{{ route('captcha.image', ['for' => 'ticket']) }}" alt="Captcha" style="height: 52px; border: 1px solid #ced4da; border-radius: 4px; background: #eef1f4;">
                                <button type="button" class="btn btn-outline-secondary ms-2" id="refresh-ticket-captcha-btn" title="Muat ulang captcha">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>

                            <input type="text" name="captcha" id="ticket-captcha" class="form-control @error('captcha') is-invalid @enderror" placeholder="Captcha" maxlength="6" autocomplete="off" style="text-transform: uppercase;" required>
                            @error('captcha')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Masukkan 6 karakter sesuai gambar</small>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-success">
                        Simpan
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@push('script-foot')
    <script>
        function openModalCreate() {
            $('#form-tiket').modal('show');
        }

        function refreshTicketCaptchaImage() {
            $.ajax({
                url: '{{ route('refresh.captcha', ['for' => 'ticket']) }}',
                type: 'GET',
                success: function(response) {
                    if (response.success && response.captcha_url) {
                        $('#ticket-captcha-image').attr('src', response.captcha_url);
                        $('#ticket-captcha').val('');
                    }
                },
                error: function() {
                    alert('Gagal memperbarui captcha');
                }
            });
        }

        function clearTicketInlineErrors() {
            $('#formCreateTicket').find('.ticket-validation-error').remove();
            $('#formCreateTicket').find('.is-invalid').removeClass('is-invalid');
        }

        // Reset form and CAPTCHA when modal is shown
        $('#form-tiket').on('shown.bs.modal', function() {
            $('#formCreateTicket')[0].reset();
            clearTicketInlineErrors();
            refreshTicketCaptchaImage();
            $('#ticket-nama').trigger('focus');
        });

        // Refresh CAPTCHA
        $('#refresh-ticket-captcha-btn').click(function() {
            refreshTicketCaptchaImage();
        });

        $('#ticket-captcha').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        window.refreshTicketCaptchaImage = refreshTicketCaptchaImage;
    </script>

    <script>
        $(document).on('submit', '#formCreateTicket', function(e) {

            e.preventDefault();

            const $form = $('#formCreateTicket');

            function clearTicketValidationErrors() {
                $form.find('.ticket-validation-error').remove();
                $form.find('.is-invalid').removeClass('is-invalid');
            }

            function showTicketValidationErrors(errors) {
                clearTicketValidationErrors();

                Object.keys(errors || {}).forEach(function(field) {
                    const message = errors[field][0];

                    if (field === 'issuetype' || field === 'department' || field === 'priority') {
                        const $fieldset = $form.find(`[name="${field}"]`).first().closest('fieldset');
                        $fieldset.find('.ticket-validation-error').remove();
                        $fieldset.find('input[name="' + field + '"]').addClass('is-invalid');
                        $fieldset.find('.col-sm-9').append(`<div class="invalid-feedback d-block ticket-validation-error">${message}</div>`);
                        return;
                    }

                    const $input = $form.find(`[name="${field}"]`).first();

                    if ($input.length) {
                        $input.addClass('is-invalid');
                        $input.closest('.col-9').find('.ticket-validation-error').remove();
                        $input.after(`<div class="invalid-feedback d-block ticket-validation-error">${message}</div>`);
                    }
                });
            }

            let formData = new FormData(this);

            clearTicketValidationErrors();

            $.ajax({
                url: "{{ route('servicedesk.store.public') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            $('#form-tiket').modal('hide');
                            $('#formCreateTicket')[0].reset();
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Gagal menyimpan tiket';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join(', ');
                    }
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        showTicketValidationErrors(xhr.responseJSON.errors);
                    }
                    if (typeof window.refreshTicketCaptchaImage === 'function') {
                        window.refreshTicketCaptchaImage();
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg,
                        confirmButtonColor: '#3085d6'
                    });
                    console.log('Error Response:', xhr.responseJSON);
                }
            });
        });
    </script>
@endpush
