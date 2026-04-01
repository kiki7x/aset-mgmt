{{-- Modal Create --}}
<div class="modal fade" data-bs-backdrop="static" id="form-tiket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Service Desk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" id="">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label" for="email"><strong>Email</strong></label>
                        <div class="col-9">
                            <input type="email" name="email" id="email" class="form-control" placeholder="">
                        </div>
                        <span id="error-email" class="text-danger small"></span>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label" for="whatsapp_number"><strong>Nomor WhatsApp</strong></label>
                        <div class="col-9">
                            <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label" for="title"><strong>Judul</strong></label>
                        <div class="col-9">
                            <input type="text" name="title" id="title" class="form-control" placeholder="">
                        </div>
                        <span id="error-title" class="text-danger small"></span>
                    </div>
                    <fieldset class="form-group mb-3">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0"><strong>Jenis</strong></legend>
                            <div class="col-sm-9">
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1">
                                    <label class="form-check-label" for="gridRadios1">
                                        Keluhan
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                                    <label class="form-check-label" for="gridRadios2">
                                        Permintaan
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group mb-3">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0" for="department"><strong>Bidang</strong></legend>
                            <div class="col-sm-9">
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="department" id="it_department" value="it">
                                    <label class="form-check-label" for="it_department">TIK</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="department" id="household_department" value="household">
                                    <label class="form-check-label" for="household_department">Rumah Tangga</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="form-group mb-3">
                        <div class="row">
                            <legend class="col-form-label col-sm-3 pt-0" for="urgency"><strong>Urgensi/Prioritas</strong></legend>
                            <div class="col-sm-9">
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="urgency" id="low_urgency" value="low">
                                    <label class="form-check-label" for="low_urgency">Rendah</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="urgency" id="medium_urgency" value="medium">
                                    <label class="form-check-label" for="medium_urgency">Sedang</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="urgency" id="high_urgency" value="high">
                                    <label class="form-check-label" for="high_urgency">Tinggi</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label" for="description"><strong>Deskripsi</strong></label>
                        <div class="col-9">
                            <textarea name="description" id="description" class="form-control" rows="3" placeholder=""></textarea>
                            <span id="error-description" class="text-danger small"></span>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-3 col-form-label" for="attachments"><strong>Lampiran (Attachments)</strong></label>
                        <div class="col-9">
                            <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                            <span id="error-attachments" class="text-danger small"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button id="submitFormEdit" type="submit" class="btn btn-success">Simpan</button>
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

{{-- <div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Formulir Tiket Service Desk</h5>
        </div>
        <form action="" method="POST" enctype="multipart/form-data" id="">
            <div class="card-body">
                @csrf
                <div class="form-group row mb-3">
                    <label class="col-2 col-form-label" for="email"><strong>Email</strong></label>
                    <div class="col-10">
                        <input type="email" name="email" id="email" class="form-control" placeholder="">
                    </div>
                    <span id="error-email" class="text-danger small"></span>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-2 col-form-label" for="whatsapp_number"><strong>Nomor WhatsApp</strong></label>
                    <div class="col-10">
                        <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-2 col-form-label" for="title"><strong>Judul</strong></label>
                    <div class="col-10">
                        <input type="text" name="title" id="title" class="form-control" placeholder="">
                    </div>
                    <span id="error-title" class="text-danger small"></span>
                </div>
                <fieldset class="form-group mb-3">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0"><strong>Jenis</strong></legend>
                        <div class="col-sm-10">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1">
                                <label class="form-check-label" for="gridRadios1">
                                    Keluhan
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                                <label class="form-check-label" for="gridRadios2">
                                    Permintaan
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="form-group mb-3">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0" for="department"><strong>Bidang</strong></legend>
                        <div class="col-sm-10">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="department" id="it_department" value="it">
                                <label class="form-check-label" for="it_department">TIK</label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="department" id="household_department" value="household">
                                <label class="form-check-label" for="household_department">Rumah Tangga</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="form-group mb-3">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0" for="urgency"><strong>Urgensi/Prioritas</strong></legend>
                        <div class="col-sm-10">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="urgency" id="low_urgency" value="low">
                                <label class="form-check-label" for="low_urgency">Rendah</label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="urgency" id="medium_urgency" value="medium">
                                <label class="form-check-label" for="medium_urgency">Sedang</label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="urgency" id="high_urgency" value="high">
                                <label class="form-check-label" for="high_urgency">Tinggi</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group row mb-3">
                    <label class="col-2 col-form-label" for="description"><strong>Deskripsi</strong></label>
                    <div class="col-10">
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder=""></textarea>
                        <span id="error-description" class="text-danger small"></span>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-2 col-form-label" for="attachments"><strong>Lampiran (Attachments)</strong></label>
                    <div class="col-10">
                        <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                        <span id="error-attachments" class="text-danger small"></span>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button id="submitFormEdit" type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div> --}}
