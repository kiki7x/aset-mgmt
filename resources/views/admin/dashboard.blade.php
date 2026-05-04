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
                    <h3>{{ $totalTickets }}</h3>

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
        <div class="col-md-6">
            <div class="card card-default shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-ticket-alt me-2"></i>
                        Tiket Helpdesk Terbaru
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($latestTickets as $ticket)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-3 py-3 border-0">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-info text-white">{{ substr($ticket->nama ?? $ticket->subject, 0, 1) }}</span>
                                </div>
                                <div>
                                    <a href="?route=tickets/manage&amp;id={{ $ticket->id }}" class="text-decoration-none fw-bold text-dark">#{{ $ticket->ticket }} {{ $ticket->subject }}</a>
                                    <div class="text-muted small">{{ $ticket->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge 
                                    @if($ticket->status == 'In Progress') bg-warning text-dark
                                    @elseif($ticket->status == 'Answered') bg-success
                                    @elseif($ticket->status == 'Closed') bg-secondary
                                    @else bg-primary
                                    @endif me-2">{{ $ticket->status }}</span>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="?route=tickets/manage&amp;id={{ $ticket->id }}"><i class="fas fa-eye me-2"></i>Lihat</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="showM(&quot;index.php?modal=tickets/edit&amp;reroute=dashboard&amp;routeid=&amp;id={{ $ticket->id }}&amp;section=&quot;);return false"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="showM(&quot;index.php?modal=tickets/delete&amp;reroute=dashboard&amp;routeid=&amp;id={{ $ticket->id }}&amp;section=&quot;);return false"><i class="fas fa-trash me-2"></i>Hapus</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
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
