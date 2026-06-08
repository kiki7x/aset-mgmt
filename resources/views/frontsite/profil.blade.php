@extends('layouts.front', ['title' => 'Profil - SAPA PPL'])

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
                            Sistem Pengelolaan Aset Poltekpar Lombok dikembangkan untuk mengotomasi proses pengelolaan Barang Milik Negara (BMN) dan mendokumentasikannya secara digital agar menjadi lebih akurat, cepat, dan efisien. Berbasis web, platform ini dirancang untuk menyajikan informasi pengelolaan secara real-time sekaligus menyediakan sistem monitoring yang terpusat.
                        </p>
                        <ul>
                            <li><i class="bi bi-check2-circle"></i> <span>Pendataan Aset Poltekpar Lombok</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Pemeliharaan Aset Poltekpar Lombok</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Lacak Aset Poltekpar Lombok</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Helpdesk sarana dan prasarana berbaris ticket</span></li>
                        </ul>
                    </div>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <p>Kehadiran platform ini merupakan langkah strategis dalam meminimalisir risiko kerusakan fasilitas dan mempercepat penanganan kendala di lapangan. Integrasi teknologi di dalamnya tidak hanya menyederhanakan birokrasi internal, tetapi juga meningkatkan mutu pelayanan sarana prasarana secara berkelanjutan.</p>
                        <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->
    </main><!-- End #main -->
@endsection
