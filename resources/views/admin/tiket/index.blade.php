@extends('layouts.backsite', [
'title' => 'Tiket Bantuan | SAPA PPL',
'welcome' => 'Tiket Bantuan',
'breadcrumb' => '<li class="breadcrumb-item active">Tiket Bantuan</li>'
])


@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">List Tiket Service Desk</h5>
        <button class="btn btn-success btn-sm"style="margin-left: auto;" onclick="printTicketReport()">
            <i class="fa fa-print"></i> Cetak PDF
        </button>
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

@endsection

@push('script-foot')
<script>
    window.ticketToOpen = @json($ticketToOpen ?? null);

    function openTicketDetail(ticket) {
        if (!ticket) {
            return;
        }

        var wa = ticket.whatsapp_number || '';
        if (wa.length > 3) {
            wa = wa.substring(0, wa.length - 3) + '***';
        }

        $('#d_ticket').text(ticket.ticket);
        $('#d_nama').text(ticket.nama);
        $('#d_email').text(ticket.email);
        $('#d_whatsapp').text(wa);
        $('#d_issuetype').text(ticket.issuetype);
        $('#d_department').text(ticket.department);
        $('#d_subject').text(ticket.subject);

        let priority = ticket.priority;
        let label = priority;

        if (priority === 'Low') {
            label = '<span style="color:#6c757d;"><i class="fa-solid fa-flag"></i> Rendah</span>';
        }
        if (priority === 'Medium') {
            label = '<span style="color:#f4b400;"><i class="fa-solid fa-flag"></i> Sedang</span>';
        }
        if (priority === 'High') {
            label = '<span style="color:#dc3545;"><i class="fa-solid fa-flag"></i> Tinggi</span>';
        }

        $('#d_priority').html(label);
        $('#d_status').text(ticket.status);
        $('#d_description').text(ticket.description);

        var status = ticket.status;
        var reason = ticket.reason || '';
        var notes = ticket.notes || '';

        if (status === 'Pending') {
            $('#row_reason').show();
            $('#row_notes').hide();
            $('#d_reason').text(reason || '-');
        } else if (status === 'Close') {
            $('#row_reason').hide();
            $('#row_notes').show();
            $('#d_notes').text(notes || '-');
        } else {
            $('#row_reason').hide();
            $('#row_notes').hide();
        }

        var gambar = ticket.attachments;
        if (gambar) {
            $('#d_attachments').attr('src', '{{ asset("storage/attachments") }}/' + gambar).show();
        } else {
            $('#d_attachments').hide();
        }

        $('#modalDetailTicket').modal('show');
    }

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
        var status = $(this).data('status');
        var reason = $(this).data('reason') || '';
        var notes = $(this).data('notes') || '';

        $('#d_status').text(status);
        $('#d_description').text($(this).data('description'));

        if (status === 'Pending') {
            $('#row_reason').show();
            $('#row_notes').hide();
            $('#d_reason').text(reason || '-');
        } else if (status === 'Close') {
            $('#row_reason').hide();
            $('#row_notes').show();
            $('#d_notes').text(notes || '-');
        } else {
            $('#row_reason').hide();
            $('#row_notes').hide();
        }

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

    function toggleEditStatusFields(status) {
        if (status === 'Pending') {
            $('#field_reason').removeClass('d-none')
            $('#edit_reason').attr('required', true)
            $('#field_close_note, #field_close_confirm').addClass('d-none')
            $('#edit_notes').removeAttr('required').val('')
            $('#edit_confirm_close').prop('checked', false).removeAttr('required')
        } else if (status === 'Close') {
            $('#field_reason').addClass('d-none')
            $('#edit_reason').removeAttr('required').val('')
            $('#field_close_note, #field_close_confirm').removeClass('d-none')
            $('#edit_notes').attr('required', true)
            $('#edit_confirm_close').attr('required', true)
        } else {
            $('#field_reason, #field_close_note, #field_close_confirm').addClass('d-none')
            $('#edit_reason, #edit_notes').removeAttr('required').val('')
            $('#edit_confirm_close').prop('checked', false).removeAttr('required')
        }
    }

    $(document).on('change', '#edit_status', function() {
        toggleEditStatusFields($(this).val())
    })

    $(document).on('click', '.edit-status', function() {

        var ticket = $(this).data('ticket')
        var status = $(this).data('status')
        var reason = $(this).data('reason') || ''
        var notes = $(this).data('notes') || ''

        ticket = $('<div>').html(ticket).text()

        $('#edit_ticket').val(ticket)
        $('#edit_status').val(status)
        $('#edit_reason').val(status === 'Pending' ? reason : '')
        $('#edit_notes').val(status === 'Close' ? notes : '')
        $('#edit_confirm_close').prop('checked', false)

        toggleEditStatusFields(status)
        $('#modalEditStatus').modal('show')
    });


    $(document).on('submit', '#formEditStatus', function(e) {
        e.preventDefault();

        var ticket = $('#edit_ticket').val();
        var status = $('#edit_status').val();
        var data = {
            ticket: ticket,
            status: status,
            _token: "{{ csrf_token() }}"
        };

        if (status === 'Pending') {
            data.reason = $('#edit_reason').val();
        }

        if (status === 'Close') {
            data.notes = $('#edit_notes').val();
            data.confirm_close = $('#edit_confirm_close').is(':checked') ? 'on' : '';
        }

        $.ajax({
            url: "{{ route('servicedesk.updateStatus') }}",
            type: 'POST',
            data: data,
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
                console.error(xhr.responseJSON || xhr.responseText);
                var message = 'Terjadi kesalahan saat memperbarui status';

                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    if (xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var firstError = Object.values(errors)[0];
                        if (firstError && firstError.length) {
                            message = firstError[0];
                        }
                    }
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message,
                    confirmButtonColor: '#d33'
                });
            }
        });
    });

    let tiketTable;

    $(document).ready(function() {
        tablePemeliharaan();
    });

    function maybeOpenTicketOnLoad() {
        if (!window.ticketToOpen || !tiketTable) {
            return;
        }

        tiketTable.one('draw', function() {
            openTicketDetail(window.ticketToOpen);
            window.ticketToOpen = null;
        });
    }

    function printTicketReport() {
        if (!tiketTable) {
            return;
        }

        let search = tiketTable.search() || '';
        let url = "{{ route('servicedesk.print') }}";

        if (search) {
            url += '?search=' + encodeURIComponent(search);
        }

        window.open(url, '_blank');
    }

    function tablePemeliharaan() {
        tiketTable = $('#tablePemeliharaan').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: "{{ route('servicedesk.data') }}",
            columns: [{
                    data: 'ticket',
                    name: 'ticket',
                    searchable: true
                },
                {
                    data: 'nama',
                    name: 'nama',
                    searchable: true
                },
                {
                    data: 'department',
                    name: 'department',
                    searchable: true,
                    render: function(data, type, row) {
                        return row.issuetype + ' - ' + row.department;
                    }
                },
                {
                    data: 'subject',
                    name: 'subject',
                    searchable: true
                },
                {
                    data: 'description',
                    name: 'description',
                    searchable: true
                },
                {
                    data: 'priority',
                    name: 'priority',
                    searchable: true,
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
                    name: 'status',
                    searchable: true
                },
                {
                    data: 'duedate',
                    name: 'duedate',
                    searchable: true
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
                        btn.setAttribute('data-notes', row.notes || '');
                        btn.textContent = 'Edit';
                        return btn.outerHTML;
                    }
                }
            ]
        });

        maybeOpenTicketOnLoad();
    }
</script>
@endpush