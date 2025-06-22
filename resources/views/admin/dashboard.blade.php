@extends('layouts.backsite', [
    'title' => 'Dashboard | SAPA PPL',
    'welcome' => 'Selamat datang '. Auth::user()->name .' di Dashboard Sistem Informasi Aset Manajemen',
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
                    <h3>{{$totalGedung}}</h3>

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
                        <i class="fas fa-tasks"></i>
                        Pemeliharaan
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
                        Helpdesk Tiket
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

@endsection