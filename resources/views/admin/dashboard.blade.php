@extends('layouts.backsite', [
    'title' => 'Dashboard | SAPA PPL',
    'welcome' => 'Selamat datang ' . Auth::user()->name . ' di Sistem Aplikasi Pemeliharaan Aset',
    // 'breadcrumb' => 'Dashboard'
])


@section('content')
    {{-- Rangkum Aset --}}
    <div class="row">
        <div class="col-md-2 col-lg-2 col-6">
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
        <div class="col-md-2 col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalAssetRt }}</h3>

                    <p>Aset Rumah Tangga</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{ route('admin.asetrt') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-md-2 col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Lisensi</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-key"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-md-2 col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>

                    <p>Pemeliharaan</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-md-2 col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Helpdesk Tiket</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-md-2 col-lg-2 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalGedung }}</h3>

                    <p>Gedung</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
    </div>{{-- /Rangkum Aset --}}

    <div class="row">
        <div class="col-md-3 col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $assetsMaintained }}</h3>
                    <p>Aset Sudah Dipelihara</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $assetsNotMaintained }}</h3>
                    <p>Aset Belum Dipelihara</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-12">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="card-title text-primary"><i class="fas fa-chart-pie mr-2"></i>Status Pemeliharaan Aset</h3>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="maintenanceStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
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
                        <li data-date="2024-07-15 10:56:02 ">
                            <span class="text"><a href="?route=tickets/manage&amp;id=2">#856929 Internet gangguan di GKT</a></span>

                            <!-- Emphasis label -->
                            <small class="badge bg-navy">In Progress</small>
                            <small>2 months ago</small>

                            <!-- General tools such as edit or delete-->
                            <div class="tools">
                                <a href="?route=tickets/manage&amp;id=2" class="btn-right text-dark"><i class="fa fa-eye"></i></a>&nbsp; <a href="#"
                                   onclick="showM(&quot;index.php?modal=tickets/edit&amp;reroute=dashboard&amp;routeid=&amp;id=2&amp;section=&quot;);return false" class="btn-right text-dark"><i class="fa fa-edit"></i></a>&nbsp; <a href="#"
                                   onclick="showM(&quot;index.php?modal=tickets/delete&amp;reroute=dashboard&amp;routeid=&amp;id=2&amp;section=&quot;);return false" class="btn-right text-red"><i class="fa fa-trash-o"></i></a>
                            </div>

                        </li>
                        <li data-date="2024-07-10 15:22:19 ">
                            <span class="text"><a href="?route=tickets/manage&amp;id=1">#810656 mohon bantu perbaikan pc</a></span>

                            <!-- Emphasis label -->
                            <small class="badge bg-teal">Answered</small>
                            <small>2 months ago</small>

                            <!-- General tools such as edit or delete-->
                            <div class="tools">
                                <a href="?route=tickets/manage&amp;id=1" class="btn-right text-dark"><i class="fa fa-eye"></i></a>&nbsp; <a href="#"
                                   onclick="showM(&quot;index.php?modal=tickets/edit&amp;reroute=dashboard&amp;routeid=&amp;id=1&amp;section=&quot;);return false" class="btn-right text-dark"><i class="fa fa-edit"></i></a>&nbsp; <a href="#"
                                   onclick="showM(&quot;index.php?modal=tickets/delete&amp;reroute=dashboard&amp;routeid=&amp;id=1&amp;section=&quot;);return false" class="btn-right text-red"><i class="fa fa-trash-o"></i></a>
                            </div>
                        </li>
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
                        Pemeliharaan Preventif dalam waktu dekat
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="callout callout-danger">
                        <h5>I am a danger callout!</h5>

                        <p>There is a problem that we need to fix. A wonderful serenity has taken possession of my entire
                            soul,
                            like these sweet mornings of spring which I enjoy with my whole heart.</p>
                    </div>
                    <div class="callout callout-info">
                        <h5>I am an info callout!</h5>

                        <p>Follow the steps to continue to payment.</p>
                    </div>
                    <div class="callout callout-warning">
                        <h5>I am a warning callout!</h5>

                        <p>This is a yellow callout.</p>
                    </div>
                    <div class="callout callout-success">
                        <h5>I am a success callout!</h5>

                        <p>This is a green callout.</p>
                    </div>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col -->

        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bullhorn"></i>
                        Pemeliharaan Korektif
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="callout callout-danger">
                        <h5>I am a danger callout!</h5>

                        <p>There is a problem that we need to fix. A wonderful serenity has taken possession of my entire
                            soul,
                            like these sweet mornings of spring which I enjoy with my whole heart.</p>
                    </div>
                    <div class="callout callout-info">
                        <h5>I am an info callout!</h5>

                        <p>Follow the steps to continue to payment.</p>
                    </div>
                    <div class="callout callout-warning">
                        <h5>I am a warning callout!</h5>

                        <p>This is a yellow callout.</p>
                    </div>
                    <div class="callout callout-success">
                        <h5>I am a success callout!</h5>

                        <p>This is a green callout.</p>
                    </div>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col -->


    </div>
@endsection

@push('script-foot')
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('maintenanceStatusChart');
            if (!ctx) {
                return;
            }
            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Aset Terpelihara', 'Menunggu Pemeliharaan'],
                    datasets: [{
                        label: 'Jumlah Aset',
                        data: [{{ $assetsMaintained }}, {{ $assetsNotMaintained }}],
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.8)', // Green
                            'rgba(255, 193, 7, 0.8)'  // Amber
                        ],
                        borderColor: ['#28a745', '#ffc107'],
                        borderWidth: 2,
                        borderRadius: 5,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed.y + ' aset';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.1)'
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutBounce'
                    }
                }
            });
        });
    </script>
@endpush
