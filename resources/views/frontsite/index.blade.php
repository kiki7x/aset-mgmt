@extends('layouts.front', ['title' => 'Home - SAPA PPL'])

{{-- @section('title', 'Kelola Aset TIK') --}}
{{-- <x-slot:title>{{ $title }}</x-slot:title> --}}

@push('scripts-head')
@endpush

@section('content')
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                        <h1>Sistem Aplikasi Pemeliharaan Aset Poltekpar Lombok</h1>
                        <p>Layanan SAPA PPL bertujuan untuk mempermudah melacak pemanfaatan aset, penjadwalan pemeliharaan aset serta
                            mempermudah penanganan laporan gangguan sarana dan prasarana bidang TIK dan Peralatan Rumah Tangga.</p>
                        <div class="d-flex">
                            <a href="{{ route('login') }}" class="btn-get-started">Mulai</a>
                            <a href="https://www.youtube.com/watch?v=92mqKMU2vuo&pp=ygUQcG9sdGVrcGFyIGxvbWJvaw%3D%3D" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Tonton Video</span></a>
                        </div>
                    </div>
                    <div id="carouselDepan" class="carousel slide col-lg-6 order-1 order-lg-2" data-bs-ride="carousel" data-aos="zoom-out" data-aos-delay="200">
                        <div class="carousel-inner rounded">
                            <div class="carousel-item active">
                                <img class="rounded img-fluid animated" loading="lazy" src="{{ asset('assets/gambar/rektorat-DJI_0769.webp') }}" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="rounded img-fluid animated" loading="lazy" src="{{ asset('assets/gambar/gedung_kuliah_1-DJI_0752.webp') }}" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="rounded img-fluid animated" loading="lazy" src="{{ asset('assets/gambar/gedung_kuliah_2-DJI_0757.webp') }}" alt="Third slide">
                            </div>
                            <div class="carousel-item">
                                <img class="rounded img-fluid animated" loading="lazy" src="{{ asset('assets/gambar/gkt_lab_hospitality.webp') }}" alt="Fourth slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" data-bs-target="#carouselDepan" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" data-bs-target="#carouselDepan" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        </section><!-- /Hero Section -->

        <!-- Clients Section -->
        <section id="clients" class="clients section light-background">
            <div class="container" data-aos="zoom-in">
                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": {
              "delay": 2000
            },
            "slidesPerView": "auto",
            "pagination": {
              "el": ".swiper-pagination",
              "type": "bullets",
              "clickable": true
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 4,
                "spaceBetween": 40
              },
              "480": {
                "slidesPerView": 5,
                "spaceBetween": 60
              },
              "640": {
                "slidesPerView": 5,
                "spaceBetween": 80
              },
              "992": {
                "slidesPerView": 6,
                "spaceBetween": 120
              },
              "1200": {
                "slidesPerView": 8,
                "spaceBetween": 120
              }
            }
          }
        </script>
                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide"><img src="{{ asset('assets/gambar/logo_hp.svg') }}" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets/gambar/logo_acer.png') }}" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets/gambar/logo_daikin.png') }}" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets/gambar/logo_grundfos.png') }}" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets/gambar/logo_epson.png') }}" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets/gambar/logo_samsung.png') }}" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets/gambar/logo_nikon.png') }}" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets/gambar/logo_toyota.png') }}" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets/gambar/logo_honda.png') }}" class="img-fluid" alt=""></div>
                        <div class="swiper-slide"><img src="{{ asset('assets/gambar/logo_daihatsu.png') }}" class="img-fluid" alt=""></div>
                    </div>
                </div>
            </div>
        </section><!-- /Clients Section -->
    </main>
@endsection

@push('scripts')
<script>
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    const barChartCanvas = $('#barChart').get(0).getContext('2d')
    const barData = {
        labels: ['Aset TIK', 'Aset Rumah Tangga'],
        datasets: [{
                label: 'Kondisi baik',
                data: [150, 350],
                borderColor: '#00a65a',
                backgroundColor: '#00a65a33',
                borderWidth: 1,
            },
            {
                label: 'Kondisi rusak',
                data: [35, 25],
                borderColor: '#f56954',
                backgroundColor: '#f5695433',
                borderWidth: 1,
            },
            {
                label: 'Kondisi dalam pemeliharaan',
                data: [25, 18],
                borderColor: '#f39c12',
                backgroundColor: '#f39c1233',
                borderWidth: 1,
            }
        ],
    };

    const config = {
        type: 'bar',
        data: barData,
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                position: 'top'
            },
            title: {
                display: true,
                text: 'Statistik Aset'
            }
        }
    }
    //Create bar chart
    // You can switch between pie and douhnut using the method below.
    new Chart(barChartCanvas, config)
</script>
@endpush
