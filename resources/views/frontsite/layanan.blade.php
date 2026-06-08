@extends('layouts.front', ['title' => 'Layanan - SAPA PPL'])

@push('scripts-head')
@endpush

@section('content')
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero-custom section dark-background">
            {{-- <div class="container"> --}}
            {{-- </div> --}}
        </section><!-- End Hero Section -->

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container">
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">Layanan</li>
                    </ol>
                </nav>
                {{-- <h1>Layanan</h1> --}}
            </div>
        </div><!-- End Page Title -->

        <!-- Services Section -->
        <section id="services" class="services section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Layanan</h2>
                <p>Beberapa cakupan fitur yang terdapat dalam aplikasi ini sebagai berikut</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">
                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-clipboard2-plus icon"></i> <span class="float-right badge bg-primary">{{ $assets->count() }}</span></div>
                            <h4><a href="" class="stretched-link">Pendataan Aset</a></h4>
                            <p>Sistem pencatatan aset secara digital yang komprehensif untuk mendokumentasikan volume, spesifikasi, nilai, dan status terkini dari seluruh properti organisasi dalam satu basis data terpusat.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-tools icon"></i></div>
                            <h4><a href="" class="stretched-link">Pemeliharaan Terjadwal</a></h4>
                            <p>Fasilitas manajemen perawatan aset secara berkala (preventif maupun korektif). Fitur ini memastikan setiap sarana dan prasarana selalu berada dalam kondisi prima untuk mendukung kelancaran operasional harian.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-qr-code-scan"></i></div>
                            <h4><a href="{{ route('lacak') }}" class="stretched-link">Lacak Aset</a></h4>
                            <p>Sistem pemantauan distribusi dan mutasi lokasi aset secara real-time. Dengan integrasi teknologi QR Code, pengguna dapat melakukan pemindaian cepat untuk memverifikasi keaslian, histori, dan posisi fisik aset secara akurat.</p>
                        </div>
                    </div><!-- End Service Item -->

                    {{-- <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-journal-check icon"></i></div>
                            <h4><a href="" class="stretched-link">Peminjaman Ruangan</a></h4>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                        </div>
                    </div> --}}

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-telephone icon"></i></div>
                            <h4><a href="{{ route('servicedesk') }}" class="stretched-link">Service Desk Sarana & Prasarana berbasis Tiket</a></h4>
                            <p>Layanan aduan dan pelaporan kerusakan fasilitas yang sistematis. Melalui sistem berbasis tiket ini, setiap kendala teknis dapat dilaporkan, diprioritaskan, dan Ditindaklanjuti oleh tim teknisi secara transparan dan akuntabel.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-lightbulb icon"></i></div>
                            <h4><a href="{{ route('knowledge-base') }}" class="stretched-link">Pusat Pengetahuan</a></h4>
                            <p>Pusat edukasi dan dokumentasi digital yang menyediakan panduan pengguna, SOP pemeliharaan, serta tips perawatan mandiri untuk membangun budaya kepedulian terhadap aset di lingkungan organisasi.</p>
                        </div>
                    </div><!-- End Service Item -->
                </div>
            </div>
        </section><!-- /Services Section -->
    </main><!-- End #main -->
@endsection
