@extends('layouts.backsite', [
    'title' => 'Dashboard | SAPA PPL',
    'welcome' => 'Selamat datang ' . Auth::user()->fullname . ' di Sistem Aplikasi Pemeliharaan Aset',
    // 'breadcrumb' => 'Dashboard'
])


@section('content')
    {{-- Rangkum Aset --}}
    <div class="row">
        <div class="col-md-2 col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalAssetTik }}</h3>
                    <p>Aset TIK</p>
                </div>
                <div class="icon">
                    <i class="fas fa-computer"></i>
                </div>
                <a href="{{ route('admin.asettik') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-md-2 col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalAssetRt }}</h3>

                    <p>Aset Rumah Tangga</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-house-chimney-window"></i>
                </div>
                <a href="{{ route('admin.asetrt') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        
        <div class="col-md-3 col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalAssetsMaintained }}</h3>
                    <p>Aset Sudah Dipelihara</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-md-3 col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalAssetsPendingMaintenance }}</h3>
                    <p>Aset Belum Dipelihara</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
    </div>{{-- /Rangkum Aset --}}

    <div class="row">
        <div class="col-md-2 col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalGedung }}</h3>

                    <p>Gedung</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{ route('admin.setting_attr.lokasi') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-md-2 col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalRuangan ?? 0 }}</h3>

                    <p>Ruangan</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                <a href="{{ route('admin.setting_attr.lokasi') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-md-2 col-lg-2 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalTickets }}</h3>

                    <p>Helpdesk Tiket</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <a href="{{ route('admin.tiket') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i>
                        Status Pemeliharaan Aset
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="maintenanceStatusChart" style="min-height: 250px; height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div><!-- ./col -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bullhorn"></i>
                        Tiket Helpdesk Terbaru
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <ul class="todo-list presort ui-sortable">
                        @foreach ($latestTickets as $ticket)
                            <li>
                                <span class="text">
                                    <a href="{{ route('admin.tiket.show', $ticket->id) }}" class="text-primary" style="font-weight: bold;">#{{ $ticket->ticket }} {{ $ticket->subject }}</a>
                                </span>
                                <!-- Emphasis label -->
                                <small
                                       class="badge 
                                @if ($ticket->status == 'In Progress') bg-warning text-dark
                                @elseif($ticket->status == 'Answered') bg-success
                                @elseif($ticket->status == 'Closed') bg-secondary
                                @else bg-primary @endif">{{ $ticket->status }}</small>
                                <small>{{ $ticket->created_at->diffForHumans() }}</small>
                                <!-- General tools such as edit or delete-->
                                <div class="tools">
                                    <a href="{{ route('admin.tiket.show', $ticket->id) }}" class="btn-right text-dark"><i class="fa fa-eye"></i></a>&nbsp;
                                    <a href="#" onclick="showM(&quot;index.php?modal=tickets/edit&amp;reroute=dashboard&amp;routeid=&amp;id={{ $ticket->id }}&amp;section=&quot;);return false" class="btn-right text-dark"><i class="fa fa-edit"></i></a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col -->
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bullhorn"></i>
                        Pemeliharaan Korektif Terbaru
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @forelse($latestKorektifItems as $maintenance)
                        @php
                            $statusBadgeClass = match ($maintenance->status) {
                                'Segera Kerjakan' => 'danger',
                                'Sedang Dikerjakan' => 'warning',
                                'Ditahan' => 'secondary',
                                'Selesai' => 'success',
                                default => 'primary',
                            };
                        @endphp
                        <div class="callout callout-light border-left-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="mb-2">{{ $loop->iteration }}. {{ $maintenance->name }}</h5>
                                <span class="badge badge-{{ $statusBadgeClass }}">{{ $maintenance->status }}</span>
                            </div>
                            <p class="mb-0 text-muted">{{ $maintenance->description ?? '-' }}</p>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Tidak ada data pemeliharaan korektif terbaru.</p>
                    @endforelse
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col -->

        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bullhorn"></i>
                        Pemeliharaan Preventif dalam waktu dekat
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @forelse($latestPreventifUpcoming as $schedule)
                        @php
                            $assetRoute = ($schedule->asset->classification_id ?? null) == 2 ? route('admin.asettik.pemeliharaan', $schedule->asset_id) : route('admin.asetrt.pemeliharaan', $schedule->asset_id);
                        @endphp
                        <div class="callout callout-info">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="mb-2">{{ $loop->iteration }}. {{ $schedule->name }}</h5>
                                <span class="badge badge-info">{{ \Illuminate\Support\Carbon::parse($schedule->start)->format('d M Y') }}</span>
                            </div>
                            <p class="mb-2">{{ $schedule->asset->name ?? '-' }}</p>
                            <a href="{{ $assetRoute }}" class="small-box-footer text-info">
                                Lihat detail aset <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Tidak ada pemeliharaan preventif dalam 30 hari mendatang.</p>
                    @endforelse
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col -->


    </div>
@endsection

@push('script-foot')
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('maintenanceStatusChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Aset Terpelihara', 'Menunggu Pemeliharaan'],
                    datasets: [{
                        label: 'Jumlah Aset',
                        data: [{{ $totalAssetsMaintained }}, {{ $totalAssetsPendingMaintenance }}],
                        backgroundColor: ['#28a745', '#ffc107'],
                        borderColor: ['#28a745', '#ffc107'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
