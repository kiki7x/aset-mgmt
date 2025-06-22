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
                        <p>Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                            deserunt mollit anim id est laborum. </p>
                        <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <!-- Services Section -->
        <section id="services" class="services section light-background">

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
                            <h4><a href="" class="stretched-link">Service Desk Sarana & Prasarana berbasis Tiket</a></h4>
                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                        </div>
                    </div><!-- End Service Item -->


                </div>

            </div>

        </section><!-- /Services Section -->

        <!-- Skills Section -->
        <section id="skills" class="skills section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Statistik</h2>
            </div><!-- End Section Title -->
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row">
                    <div class="col-lg-4 pt-4 pt-lg-0 content">
                        <h3>Progress</h3>
                        <p class="fst-italic">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                        <div class="skills-content skills-animation">
                            <div class="progress">
                                <span class="skill"><span>Jumlah Aset</span> <i class="val">{{ $assets->count() }}</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div><!-- End Skills Item -->
                            <div class="progress">
                                <span class="skill"><span>Progres Pendataan Aset</span> <i class="val">75%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PIE CHART -->
                    <div class="col-lg-8 pt-4 pt-lg-0 content">
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

        </section><!-- /Skills Section -->

        <!-- Team Section -->
        <section id="team" class="team section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Team</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-6" data-aos="fade-up">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="{{ asset('assets/gambar/wawan.jpg') }}" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Wawan Apriandi, S.Si.</h4>
                                <span>Koordinator BMN</span>
                                <p>Explicabo voluptatem mollitia et repellat qui dolorum quasi</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-6" data-aos="fade-up">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="{{ asset('assets/gambar/kadek.jpg') }}" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>I Kadek Surianta, S.Sos.H., M.IKom.</h4>
                                <span>Koordinator Rumah Tangga</span>
                                <p>Aut maiores voluptates amet et quis praesentium qui senda para</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-6" data-aos="fade-up">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="{{ asset('assets/gambar/kiki.jpg') }}" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Selamet Kiki Pranoto, S.Kom.</h4>
                                <span>Koordinator TIK</span>
                                <p>Quisquam facilis cum velit laborum corrupti fuga rerum quia</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-6" data-aos="fade-up">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="{{ asset('assets/gambar/didik.jpg') }}" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Didi Irawan, A.Md.</h4>
                                <span>Tim BMN</span>
                                <p>Dolorum tempora officiis odit laborum officiis et et accusamus</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->
                </div>
            </div>
        </section><!-- /Team Section -->

        <!-- Faq 2 Section -->
        <section id="faq-2" class="faq-2 section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Frequently Asked Questions</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi
                    quidem hic quas.</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-10">

                        <div class="faq-container">

                            <div class="faq-item faq-active" data-aos="fade-up" data-aos-delay="200">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                                <div class="faq-content">
                                    <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?</h3>
                                <div class="faq-content">
                                    <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper
                                        dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                                <div class="faq-content">
                                    <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis
                                        convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h3>
                                <div class="faq-content">
                                    <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper
                                        dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Tempus quam pellentesque nec nam aliquam sem et tortor consequat?</h3>
                                <div class="faq-content">
                                    <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis
                                        blandit turpis cursus in</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Faq 2 Section -->

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
