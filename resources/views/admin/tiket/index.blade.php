@extends('layouts.backsite', [
'title' => 'Tiket Bantuan | SAPA PPL',
'welcome' => 'Tiket Bantuan',
'breadcrumb' => '<li class="breadcrumb-item active">Tiket Bantuan</li>'
])


@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">List Tiket Service Desk</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tablePemeliharaan" class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Tiket</th>
                        <th>Pemohon</th>
                        <th>Jenis & Bidang</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Prioritas</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="modalDetailTicket">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Tiket</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
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
                    <tr>
                        <th>Alasan</th>
                        <td id="d_reason"></td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td id="d_description"></td>
                    </tr>
                </table>
                <div class="form-group row mb-3">
                    <label class="col-3 col-form-label"><strong>Lampiran</strong></label>
                    <div class="col-9">
                        <img id="d_attachments" src="" width="200" style="cursor:pointer; display:none;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="modalImage" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="imgPreview" src="" style="width:100%">
            </div>
        </div>
    </div>
</div>

<!-- Edit Status Modal -->
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
                    <div class="form-group">
                        <label for="edit_reason">Alasan</label>
                        <textarea class="form-control" id="edit_reason" name="reason" rows="3" required></textarea>
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

@endsection

@push('script-foot')
<script>
    $(document).on('click', '.lihat-tiket', function(e) {
        e.preventDefault();
        var wa = $(this).data('wa');

        if (wa) {
            wa = wa.toString();
            if (wa.length > 3) {
                wa = wa.substring(0, wa.length - 3) + '***';
            }
        }

        $('#d_ticket').text($(this).data('ticket'));
        $('#d_nama').text($(this).data('nama'));
        $('#d_email').text($(this).data('email'));
        $('#d_whatsapp').text(wa);
        $('#d_issuetype').text($(this).data('issuetype'));
        $('#d_department').text($(this).data('department'));
        $('#d_subject').text($(this).data('subject'));
        let priority = $(this).data('priority');
        let label = priority;

        if (priority == 'Low') {
            label = '<span style="color:#6c757d;"><i class="fa-solid fa-flag"></i> Rendah</span>';
        }
        if (priority == 'Medium') {
            label = '<span style="color:#f4b400;"><i class="fa-solid fa-flag"></i> Sedang</span>';
        }
        if (priority == 'High') {
            label = '<span style="color:#dc3545;"><i class="fa-solid fa-flag"></i> Tinggi</span>';
        }

        $('#d_priority').html(label);
        $('#d_status').text($(this).data('status'));
        $('#d_reason').text($(this).data('reason') || '-');
        $('#d_description').text($(this).data('description'));

        let gambar = $(this).data('attachments');

        if (gambar) {
            $('#d_attachments').attr('src', '{{ asset("storage/attachments") }}/' + gambar).show();
        } else {
            $('#d_attachments').hide();
        }

        $('#modalDetailTicket').modal('show');
    });

    $('#d_attachments').on('click', function() {
        let src = $(this).attr('src');
        $('#imgPreview').attr('src', src);
        $('#modalImage').modal('show');
    });

    $(document).on('click', '.edit-status', function() {

        var ticket = $(this).data('ticket')
        var status = $(this).data('status')
        var reason = $(this).data('reason') || ''

      
        ticket = $('<div>').html(ticket).text()

        $('#edit_ticket').val(ticket)
        $('#edit_status').val(status)
        $('#edit_reason').val(reason)

        $('#modalEditStatus').modal('show')
    });


    $(document).on('submit', '#formEditStatus', function(e) {
        e.preventDefault();

        var ticket = $('#edit_ticket').val();
        var status = $('#edit_status').val();
        var reason = $('#edit_reason').val();

        $.ajax({
            url: "{{ route('servicedesk.updateStatus') }}",
            type: 'POST',
            data: {
                ticket: ticket,
                status: status,
                reason: reason,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        $('#modalEditStatus').modal('hide');
                        $('#tablePemeliharaan').DataTable().ajax.reload();
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memperbarui status',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });

    $(document).ready(function() {
        tablePemeliharaan();
    });

    function tablePemeliharaan() {
        $('#tablePemeliharaan').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('servicedesk.data') }}",
            columns: [{
                    data: 'ticket',
                    name: 'ticket'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return row.issuetype + ' - ' + row.department;
                    }
                },
                {
                    data: 'subject',
                    name: 'subject'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'priority',
                    name: 'priority',
                    render: function(data) {
                        if (data == 'Low') {
                            return '<span style="color:#6c757d;"><i class="fa-solid fa-flag"></i> Rendah</span>';
                        }
                        if (data == 'Medium') {
                            return '<span style="color:#f4b400;"><i class="fa-solid fa-flag"></i> Sedang</span>';
                        }
                        if (data == 'High') {
                            return '<span style="color:#dc3545;"><i class="fa-solid fa-flag"></i> Tinggi</span>';
                        }
                        return data;
                    }
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'duedate',
                    name: 'duedate'
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'btn btn-sm btn-primary edit-status';
                        btn.setAttribute('data-ticket', row.ticket);
                        btn.setAttribute('data-status', row.status);
                        btn.setAttribute('data-reason', row.reason || '');
                        btn.textContent = 'edit status';
                        return btn.outerHTML;
                    }
                }
            ]
        });
    }
</script>
@endpush