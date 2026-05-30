<div class="modal fade" id="modalEditStatus">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Status Tiket</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formEditStatus">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_ticket">Nomor Tiket</label>
                        <input type="text" class="form-control" id="edit_ticket" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Open">Open</option>
                            <option value="Pending">Pending</option>
                            <option value="Proses">Proses</option>
                            <option value="Close">Close</option>
                        </select>
                    </div>
                    <div class="form-group" id="field_reason">
                        <label for="edit_reason">Alasan</label>
                        <textarea class="form-control" id="edit_reason" name="reason" rows="3" required></textarea>
                    </div>
                    <div class="form-group d-none" id="field_close_note">
                        <label for="edit_notes">Catatan</label>
                        <textarea class="form-control" id="edit_notes" name="notes" rows="3"></textarea>
                    </div>
                    <div class="form-group form-check d-none" id="field_close_confirm">
                        <input type="checkbox" class="form-check-input" id="edit_confirm_close" name="confirm_close" value="1">
                        <label class="form-check-label" for="edit_confirm_close">Saya yakin ingin menutup tiket ini</label>
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
