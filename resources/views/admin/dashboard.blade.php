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
                        @foreach($latestTickets as $ticket)
                        <li>
                            <span class="text">
                                <a href="{{ route('admin.tiket.show', $ticket->id) }}" class="text-primary" style="font-weight: bold;">#{{ $ticket->ticket }} {{ $ticket->subject }}</a>
                            </span>
                            <!-- Emphasis label -->
                            <small class="badge 
                                @if($ticket->status == 'In Progress') bg-warning text-dark
                                @elseif($ticket->status == 'Answered') bg-success
                                @elseif($ticket->status == 'Closed') bg-secondary
                                @else bg-primary
                                @endif">{{ $ticket->status }}</small>
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
