<div class="modal fade" id="modalDetailTicket">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Tiket</h5>
                &nbsp;
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered">

                    <tr>
                        <th>Nomor Tiket</th>
                        <td id="d_ticket"></td>
                    </tr>

                    <tr>
                        <th>Nama</th>
                        <td id="d_nama"></td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td id="d_email"></td>
                    </tr>

                    <tr>
                        <th>WhatsApp</th>
                        <td id="d_whatsapp"></td>
                    </tr>

                    <tr>
                        <th>Jenis</th>
                        <td id="d_issuetype"></td>
                    </tr>

                    <tr>
                        <th>Bidang</th>
                        <td id="d_department"></td>
                    </tr>

                    <tr>
                        <th>Judul</th>
                        <td id="d_subject"></td>
                    </tr>

                    <tr>
                        <th>Prioritas</th>
                        <td id="d_priority"></td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td id="d_status"></td>
                    </tr>

                    <tr id="row_reason" style="display: none;">
                        <th>Alasan</th>
                        <td id="d_reason"></td>
                    </tr>
                    <tr id="row_notes" style="display: none;">
                        <th>Catatan</th>
                        <td id="d_notes"></td>
                    </tr>

                    <tr>
                        <th>Deskripsi</th>
                        <td id="d_description"></td>
                    </tr>

                </table>
                <div class="form-group row mb-3">
                    <label class="col-3 col-form-label"><strong>Lampiran</strong></label>
                    <div class="col-9">

                        <img id="d_attachments" src="" width="200" style="cursor:pointer; " display:none">

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modalImage" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-body text-center">

                <img id="imgPreview" src="" style="width:100%">

            </div>

        </div>
    </div>
</div>
