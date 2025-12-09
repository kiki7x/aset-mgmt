@extends('layouts.front', ['title' => 'Home - SAPA PPL'])

@push('scripts-head')
@endpush

@section('content')
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero-custom section dark-background">
        </section><!-- End Hero Section -->
        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container">
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">Profil</li>
                    </ol>
                </nav>
                {{-- <h1>Profil</h1> --}}
            </div>
        </div><!-- End Page Title -->

        <!-- About Section -->
        <section id="about" class="about section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Profil</h2>
            </div><!-- End Section Title -->
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            Sistem Pengelolaan Aset Poltekpar Lombok dikembangkan untuk mengotomasi proses pengelolaan BMN dan mendokumentasikannya secara digital, proses menjadi lebih akurat, cepat, dan efisien. Berbasis web diharapkan dapat
                            menyajikan informasi pengelolaan BMN secara akurat dan terkini, serta menyediakan sistem monitoring online dan realtime.
                        </p>
                        <ul>
                            <li><i class="bi bi-check2-circle"></i> <span>Pendataan Aset Poltekpar Lombok</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Pemeliharaan Aset Poltekpar Lombok</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Lacak Aset Poltekpar Lombok</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Helpdesk sarana dan prasarana berbaris ticket</span></li>
                        </ul>
                    </div>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <p>Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                            officia
                            deserunt mollit anim id est laborum. </p>
                        <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->
    </main><!-- End #main -->
@endsection
