<div class="modal fade" id="add-schedulev2" data-backdrop="static" tabindex="-1" aria-labelledby="add-schedulev2-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-schedulev2-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formJadwalV2">
                    <input type="hidden" id="v2_name" name="name">
                    <input type="hidden" id="v2_start" name="start">
                    <div class="form-group">
                        <label for="v2_frequency">Frekuensi Pemeliharaan <span class="text-danger">*</span></label>
                        <select class="form-control" id="v2_frequency" name="frequency" required>
                            <option value="">-- Pilih --</option>
                            <option value="3">Setiap 3 bulan sekali</option>
                            <option value="4">Setiap 4 bulan sekali</option>
                            <option value="6">Setiap 6 bulan sekali</option>
                            <option value="12">Setiap 12 bulan sekali</option>
                        </select>
                        <span class="text-danger small" id="error-v2_frequency"></span>
                    </div>
                    <div class="form-group">
                        <label for="v2_end">Periode Selanjutnya <span class="text-danger">*</span></label>
                        <input id="v2_end" width="276" type="text" class="form-control" name="end" placeholder="DD MMM YYYY" required>
                        <span class="text-danger small" id="error-v2_end"></span>
                    </div>
                    <div class="form-group">
                        <label for="v2_reminder">Pengingat (hari sebelum jatuh tempo)</label>
                        <input type="number" id="v2_reminder" name="reminder" class="form-control" value="7" min="0">
                        <span class="text-danger small" id="error-v2_reminder"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Jadwalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
