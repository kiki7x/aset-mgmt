@extends('layouts.backsite', [
    'title' => 'Pemeliharaan Preventif | SAPA PPL',
    'welcome' => 'Pemeliharaan Preventif',
    'breadcrumb' => '
<li class="breadcrumb-item active">Pemeliharaan Preventif</li>',
])

@push('script-head')
    {{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" /> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex bd-highlight">
            <h3 class="card-title font-weight-bold mr-auto p-2 bd-highlight"><i class="fa-regular fa-calendar"></i> Kalender Pemeliharaan</h3>
        </div>
        <div class="card-body">
            <!-- THE CALENDAR -->
            <div id="calendar"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex bd-highlight">
            <h3 class="card-title font-weight-bold mr-auto p-2 bd-highlight"><i class="fa-regular fa-calendar-check"></i> Riwayat Pemeliharaan Preventif</h3>
            <div class="bd-highlight mr-2">
                <button class="btn btn-success btn-sm"style="margin-left: auto;" onclick="printPreventifReport()">
                    <i class="fa fa-print"></i> Cetak PDF
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-2 mb-3 align-items-end">
                <div class="col-12 col-md-3">
                    <label for="filter_classification" class="form-label">Filter Klasifikasi</label>
                    <select id="filter_classification" class="form-control form-control-sm w-100">
                        <option value="">Semua Klasifikasi</option>
                        <option value="Keluhan">TIK</option>
                        <option value="Permintaan">Rumah Tangga</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label for="filter_date" class="form-label">Filter Waktu</label>
                    <div class="bd-highlight">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" name="filter_date" class="form-control form-control-sm" id="reservation">
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="table-responsive">
                <table id="completedPreventiveTable" class="table table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Periode</th>
                            <th>Judul Pemeliharaan</th>
                            <th>Nama Aset</th>
                            <th>PIC</th>
                            <th>Biaya</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Bukti Dukung</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Detail Event --}}
    @include('admin.pemeliharaan-preventif.partials.event-detail')
    @include('admin.pemeliharaan-preventif.partials.tl-preventif')
    @include('admin.pemeliharaan-preventif.partials.add-jadwal')

    @push('script-foot')
        <script src="{{ asset('/assets/plugins/fullcalendar-6.1.20/dist/index.global.min.js') }}"></script>
        <script src="{{ asset('/assets/plugins/fullcalendar-6.1.20/dist/id.global.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                window.calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'id', // Set locale ke Bahasa Indonesia
                    initialView: 'dayGridMonth',
                    // editable: true, // Memungkinkan drag-and-drop (butuh interactionPlugin)
                    selectable: true,
                    displayEventTime: true,
                    displayEventEnd: true,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek' // 'listWeek' berasal dari listPlugin
                    },
                    events: {
                        url: '{{ route('admin.pemeliharaan-preventif.get-maintenance-schedules') }}',
                        method: 'GET',
                        failure: function() {
                            console.error('Error fetching maintenance schedules');
                        }
                    },
                    // test render event dengan custom HTML (opsional, bisa dihapus jika tidak diperlukan)
                    eventContent: function(info) {
                        // return {
                        //     // tambahkan kondisi jika membedakan antara event atau history berdasarkan extendedProps atau properti lainnya
                        //     html: '<i class="fas fa-check-circle"></i> ' + info.event.title + '<br/>' + ' Tag: ' + info.event.extendedProps.tag
                        // };

                        // kondisi jika events memiliki ikon jam, jika histories memiliki ikon ceklis
                        if (info.event.extendedProps.is_event) {
                            icon = '<i class="fas fa-clock"></i> ';
                            timetogo = moment(info.event.start).fromNow();
                        } else {
                            icon = '<i class="fas fa-check-circle"></i> ';
                            timetogo = moment(info.event.start).fromNow(); // Menampilkan waktu relatif seperti "2 hari yang lalu"
                        }

                        return {
                            // html: icon + info.event.title + '<br/>' + ' Tag: ' + info.event.extendedProps.tag + '<br/>' + timetogo
                            html: info.event.title + '<br/>' + ' Tag: ' + info.event.extendedProps.tag + '<br/>' + icon + ' ' + timetogo
                        };
                    },
                    // Interaction plugin memungkinkan event ini
                    dateClick: function(info) {
                        const clickedDate = info.dateStr; // Format tanggal yang diklik (YYYY-MM-DD)
                        // panggil event membuka modal add preventif dengan data tanggal yang diklik
                        // alert('Tanggal diklik: ' + info.dateStr); // debug tanggal yang diterima di event dateClick
                        showModalAddJadwal(clickedDate);
                    },

                    // Interaksi klik event untuk menampilkan modal detail dalam modal
                    eventClick: function(info) {
                        // 1. Ambil data dari objek event yang diklik
                        const eventObj = info.event;
                        const id = info.event.id; // Ambil ID event
                        const description = eventObj.extendedProps.description; // Ambil properti tambahan seperti 'description'

                        // Ambil flag is_event (pastikan dari API sudah mengirimkan nilai ini)
                        const isEvent = eventObj.extendedProps.is_event;

                        // KONDISI A: Jika is_event bernilai true (Tampilkan Detail)
                        if (isEvent === true || isEvent === 'true' || isEvent == 1) {
                            // bungkus data yang diperlukan untuk modal add preventif dalam sebuah objek
                            // const eventData = {
                            //     id: id,
                            //     title: info.event.title,
                            //     description: description,
                            //     start: eventObj.start,
                            //     end: eventObj.end,
                            //     // tambahkan properti lain yang diperlukan untuk modal add preventif
                            //     notes: eventObj.extendedProps.notes,
                            //     tag: eventObj.extendedProps.tag,
                            //     frequency: eventObj.extendedProps.frequency,
                            //     color: eventObj.backgroundColor,
                            // };

                            // alert(JSON.stringify(eventObj)); // debug data yang akan diterima di modal add preventif
                            // panggil function showModalAddPreventif dengan data yang diterima
                            showModalTlPreventif(eventObj);
                        } else {
                            historyData = {
                                title: info.event.title,
                                description: description,
                                start: eventObj.start,
                                // extendedProps
                                attachment_link: eventObj.extendedProps.attachment_link,
                                id_asset: eventObj.extendedProps.id_asset,
                                classification: eventObj.extendedProps.classification,
                                cost: eventObj.extendedProps.cost,
                                notes: eventObj.extendedProps.notes,
                                asset: eventObj.extendedProps.asset,
                                status: eventObj.extendedProps.status,
                            };
                            // alert(JSON.stringify(historyData)); // debug data yang akan ditampilkan di modal history
                            // Tampilkan modal event-detail
                            // alert(JSON.stringify(historyData)); // debug data yang akan diterima di modal event-detail
                            showModalEventDetail(historyData);
                        }
                        // // 2. Isi konten modal secara dinamis
                        // $('#eventTitle').text(eventObj.title);
                        // $('#eventDescription').text(description);
                        // // $('#eventTime').text(eventObj.start.toLocaleString());
                        // $('#eventTime').text(moment(eventObj.start).format('DD MMM YYYY')); // Format waktu menggunakan moment.js
                        // $('#eventNotes').text(eventObj.extendedProps.notes || 'Tidak ada catatan'); // Tampilkan catatan jika ada, atau teks default jika tidak ada

                        // // 3. Tampilkan modal
                        // const myModal = new bootstrap.Modal(document.getElementById('event-detail'), {
                        //     keyboard: false
                        // });
                        // myModal.show();
                    },

                    eventDidMount: function(info) {
                        // Tambahkan tooltip menggunakan Bootstrap
                        let tooltipTitle = '';
                        const isEvent = info.event.extendedProps.is_event;

                        if (isEvent) {
                            // 1. Jika ini adalah jadwal (is_event === true)
                            tooltipTitle = 'Jadwal Pemeliharaan: ' + info.event.title + ' untuk aset ' + (info.event.extendedProps.description || 'Tidak ada deskripsi');
                        } else {
                            // 2. Jika ini adalah riwayat (is_event === false)
                            tooltipTitle = 'Riwayat pemeliharaan: ' + (info.event.extendedProps.tag || 'No tag') + ' ' + (info.event.extendedProps.description || 'No description');
                        }

                        var tooltip = new bootstrap.Tooltip(info.el, {
                            title: tooltipTitle,
                            placement: 'auto',
                            trigger: 'hover',
                            container: 'body'
                        });
                    }
                });
                window.calendar.render();

                if ($.fn.DataTable) {
                    window.completedPreventiveTable = $('#completedPreventiveTable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: {
                            url: '{{ route('admin.pemeliharaan-preventif.completed-data-table') }}',
                            data: function(d) {
                                var picker = $('#reservation').data('daterangepicker');
                                if ($('#reservation').val()) {
                                    d.start_date = picker.startDate.format('YYYY-MM-DD');
                                    d.end_date = picker.endDate.format('YYYY-MM-DD');
                                }
                            }
                        },
                        columns: [{
                                data: null,
                                render: function(data, type, row, meta) {
                                    return meta.row + 1;
                                },
                                className: 'text-center',
                                orderable: false,
                                width: '40px'
                            },
                            {
                                data: 'period'
                            },
                            {
                                data: 'maintenance_name'
                            },
                            {
                                data: 'asset_name',
                                render: function(data, type, row) {
                                    if (row.classification_name == 'TIK') {
                                        return '<a href="/admin/asettik/' + row.asset_id + '/overview" target="_blank">' + row.asset_tag + '<br>' + row.asset_name + '<i class="fa fa-external-link"></i>' + '</a>';
                                    } else if (row.classification_name == 'Kendaraan' || row.classification_name == 'Mesin/Elektronik') {
                                        return '<a href="/admin/asetrt/' + row.asset_id + '/overview" target="_blank">' + row.asset_tag + '<br>' + row.asset_name + '<i class="fa fa-external-link"></i>' + '</a>';
                                    } else {
                                        return row.asset_tag + ' - ' + row.asset_name;
                                    }
                                }
                            },
                            {
                                data: 'pic_name'
                            },
                            {
                                data: 'cost'
                            },
                            {
                                data: 'status'
                            },
                            {
                                data: 'notes'
                            },
                            {
                                data: 'attachment_link',
                                render: function(data, type, row) {
                                    if (data) {
                                        return `<a href="${data}" target="_blank">${data}</a>`;
                                    } else {
                                        return '-';
                                    }
                                }
                            }
                        ],
                        order: [
                            [1, 'desc']
                        ],
                        language: {
                            emptyTable: 'Tidak ada data.',
                            processing: 'Memuat...',
                            search: 'Cari:',
                            lengthMenu: 'Tampilkan _MENU_ baris',
                            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                            infoEmpty: 'Menampilkan 0 sampai 0 dari 0 entri',
                            paginate: {
                                previous: 'Sebelumnya',
                                next: 'Berikutnya'
                            }
                        }
                    });
                }
            });
        </script>

        <script>
            //Date range picker
            $('#reservation').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'DD/MM/YYYY',
                    cancelLabel: 'Clear'
                },
                autoUpdateInput: false
            });

            $('#reservation').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                window.completedPreventiveTable.draw();
            });

            $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                window.completedPreventiveTable.draw();
            });
        </script>

        <script>
            function printPreventifReport() {
                if (!completedPreventiveTable) {
                    return;
                }

                let search = completedPreventiveTable.search() || '';
                // let issuetype = $('#filter_issuetype').val() || '';
                // let department = $('#filter_department').val() || '';
                let url = "{{ route('admin.pemeliharaan-preventif.print') }}";

                if (search) {
                    url += '?search=' + encodeURIComponent(search);
                }

                let queryParts = [];

                if (search) {
                    queryParts.push('search=' + encodeURIComponent(search));
                }

                // if (issuetype) {
                //     queryParts.push('issuetype=' + encodeURIComponent(issuetype));
                // }

                // if (department) {
                //     queryParts.push('department=' + encodeURIComponent(department));
                // }

                if (queryParts.length) {
                    url = "{{ route('admin.pemeliharaan-preventif.print') }}" + '?' + queryParts.join('&');
                }

                window.open(url, '_blank');
            }
        </script>

        <style>
            #calendar {
                max-width: 100vh;
                margin: 0 auto;
            }
        </style>
    @endpush
@endsection
