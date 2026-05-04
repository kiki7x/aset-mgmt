@extends('layouts.backsite', [
    'title' => 'Pemeliharaan Preventif | SAPA PPL',
    'welcome' => 'Pemeliharaan Preventif',
    'breadcrumb' => '
<li class="breadcrumb-item active">Pemeliharaan Preventif</li>',
])

@push('script-head')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 class="card-title">Kalender Pemeliharaan</h3>
                        <button type="button" class="btn btn-outline-primary" style="margin-left: auto;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->

    {{-- Modal Detail Event --}}
    @include('admin.pemeliharaan-preventif.partials.event-detail')
    @include('admin.pemeliharaan-preventif.partials.add-preventif')

    @push('script-foot')
        <script src="{{ asset('/assets/plugins/fullcalendar-6.1.20/dist/index.global.min.js') }}"></script>
        <script src="{{ asset('/assets/plugins/fullcalendar-6.1.20/dist/id.global.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'id', // Set locale ke Bahasa Indonesia
                    initialView: 'dayGridMonth',
                    editable: true, // Memungkinkan drag-and-drop (butuh interactionPlugin)
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
                        alert('Tanggal diklik: ' + info.dateStr);
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
                            const eventData = {
                                id: id,
                                title: eventObj.title,
                                description: description,
                                start: eventObj.start,
                                notes: eventObj.extendedProps.notes,
                                // tambahkan properti lain yang diperlukan untuk modal add preventif
                            };
                            // panggil function showModalAddPreventif dengan data yang diterima
                            showModalAddPreventif(id, eventData);
                        } else {
                            // KONDISI B: Jika is_event bernilai false (Tampilkan History)
                            // Isi konten modal detail secara dinamis
                            // $('#eventTitle').text(eventObj.title);
                            // $('#eventDescription').text(description);
                            // $('#eventTime').text(eventObj.start.toLocaleString());
                            // $('#eventTime').text(moment(eventObj.start).format('DD MMM YYYY')); // Format waktu menggunakan moment.js
                            // $('#eventNotes').text(eventObj.extendedProps.notes || 'Tidak ada catatan'); // Tampilkan catatan jika ada, atau teks default jika tidak ada
                            historyData = {
                                title: info.event.title,
                                description: description,
                                start: eventObj.start,
                                // extendedProps
                                attachment_link: eventObj.extendedProps.attachment_link,
                                cost: eventObj.extendedProps.cost,
                                notes: eventObj.extendedProps.notes,
                                asset: eventObj.extendedProps.asset,
                                status: eventObj.extendedProps.status,
                            };
                            // Tampilkan modal event-detail
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
                        var tooltip = new bootstrap.Tooltip(info.el, {
                            title: 'Riwayat pemeliharaan selesai pada aset: ' + (info.event.extendedProps.tag || 'No tag') + ' ' + (info.event.extendedProps.description || 'No description'),
                            placement: 'auto',
                            trigger: 'hover',
                            container: 'body'
                        });
                    }
                });
                calendar.render();
            });
        </script>
        <style>
            #calendar {
                max-width: 100vh;
                margin: 0 auto;
            }
        </style>
    @endpush
@endsection
