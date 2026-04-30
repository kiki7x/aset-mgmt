{{-- Modal Create --}}
<div class="modal fade" data-bs-backdrop="static" id="form-tiket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Form Service Desk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formCreateTicket" action="{{ route('servicedesk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" id="modalCreateTicket">

                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label"><strong>Nama</strong></label>
                        <div class="col-9">
                            <input type="text" name="nama" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label"><strong>Email</strong></label>
                        <div class="col-9">
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label"><strong>Nomor WhatsApp</strong></label>
                        <div class="col-9">
                            <input type="text" name="whatsapp_number" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label"><strong>Judul</strong></label>
                        <div class="col-9">
                            <input type="text" name="subject" class="form-control">
                        </div>
                    </div>

                    {{-- Jenis --}}
                    <fieldset class="form-group mb-3">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0"><strong>Jenis</strong></legend>
                            <div class="col-sm-9">

                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="issuetype" value="Keluhan">
                                    <label class="form-check-label">
                                        Keluhan
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="issuetype" value="Permintaan">
                                    <label class="form-check-label">
                                        Permintaan
                                    </label>
                                </div>

                            </div>
                        </div>
                    </fieldset>

                    {{-- Department --}}
                    <fieldset class="form-group mb-3">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0"><strong>Bidang</strong></legend>
                            <div class="col-sm-9">

                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="department" value="TIK">
                                    <label class="form-check-label">
                                        TIK
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="department" value="Rumah Tangga">
                                    <label class="form-check-label">
                                        Rumah Tangga
                                    </label>
                                </div>

                            </div>
                        </div>
                    </fieldset>

                    {{-- Priority --}}
                    <fieldset class="form-group mb-3">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0"><strong>Urgensi / Prioritas</strong></legend>

                            <div class="col-sm-9">

                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="priority" value="Low">
                                    <label class="form-check-label">
                                        Rendah
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="priority" value="Medium">
                                    <label class="form-check-label">
                                        Sedang
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="priority" value="High">
                                    <label class="form-check-label">
                                        Tinggi
                                    </label>
                                </div>

                            </div>
                        </div>
                    </fieldset>

                    {{-- Deskripsi --}}
                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label"><strong>Deskripsi</strong></label>
                        <div class="col-9">
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    {{-- Attachment --}}
                    <div class="form-group row mb-3">

                        <label class="col-3 col-form-label">
                            <strong>Lampiran</strong>
                        </label>

                        <div class="col-9">

                            <input
                                type="file"
                                name="attachments"
                                class="form-control"
                                accept="image/*">

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
</script>

@endpush