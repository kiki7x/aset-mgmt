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
                            <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-tools icon"></i></div>
                            <h4><a href="" class="stretched-link">Pemeliharaan</a></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-qr-code-scan"></i></div>
                            <h4><a href="{{ route('lacak') }}" class="stretched-link">Lacak Aset</a></h4>
                            <p>Lacak aset yang sudah didistribusikan menggunakan fitur scan QR Code</p>
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
                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                        </div>
                    </div><!-- End Service Item -->
                </div>
            </div>
        </section><!-- /Services Section -->
    </main><!-- End #main -->
@endsection
