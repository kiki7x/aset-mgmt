<div class="modal fade" id="add-tugas-preventifv2" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="add-tugas-preventifv2-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-tugas-preventifv2-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTugasPreventifV2" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="name" id="v2tl_name">
                    <input type="hidden" name="period" id="v2tl_period">
                    <input type="hidden" name="future_period" id="v2tl_future_period">
                    <div class="form-group">
                        <label for="v2tl_attachment_link">Link Bukti Dukung <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="v2tl_attachment_link" name="attachment_link" required>
                        <small class="form-text text-muted">Masukkan link google drive</small>
                        <span id="error-v2tl_attachment_link" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="v2tl_cost">Biaya <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="v2tl_cost" name="cost" placeholder="Rp 0" required>
                        <span id="error-v2tl_cost" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <label for="v2tl_notes">Catatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="4" id="v2tl_notes" name="notes" required></textarea>
                        <span id="error-v2tl_notes" class="text-danger small"></span>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="v2tl_checkbox" name="confirmed" value="1" required>
                            <label for="v2tl_checkbox" class="custom-control-label font-weight-normal">
                                Saya telah menyelesaikan tugas ini. Periode pemeliharaan berikutnya: <span id="v2tl_future_text" class="badge badge-info"></span>
                                <span class="text-danger">*</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
