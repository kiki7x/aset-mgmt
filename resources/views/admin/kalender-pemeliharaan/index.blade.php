@extends('layouts.backsite', [
'title' => 'Kalender Pemeliharaan | SAPA PPL',
'welcome' => 'Kalender Pemeliharaan',
'breadcrumb' => '
<li class="breadcrumb-item active">Kalender Pemeliharaan</li>',
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

@push('script-foot')
<script src="{{ asset('/assets/plugins/fullcalendar-6.1.20/dist/index.global.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true, // Memungkinkan drag-and-drop (butuh interactionPlugin)
            selectable: true,
            displayEventTime: true,
            displayEventEnd: true,
            events: {
                url: '{{ route("admin.kalender-pemeliharaan.get_maintenance_schedules") }}',
                method: 'GET',
                failure: function() {
                    console.error('Error fetching maintenance schedules');
                }
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek' // 'listWeek' berasal dari listPlugin
            },
            // Interaction plugin memungkinkan event ini
            dateClick: function(info) {
                alert('Tanggal diklik: ' + info.dateStr);
            },
            eventDidMount: function(info) {
                // Tambahkan tooltip menggunakan Bootstrap
                var tooltip = new bootstrap.Tooltip(info.el, {
                    title: info.event.extendedProps.description || 'No description',
                    placement: 'top',
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