@extends('layouts.front', ['title' => 'Team - SAPA PPL'])

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
                        <li class="current">Team</li>
                    </ol>
                </nav>
                {{-- <h1>Layanan</h1> --}}
            </div>
        </div><!-- End Page Title -->

        <!-- Team Section -->
        <section id="team" class="team section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Team</h2>
                <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4 justify-content-center">

                    <div class="col-lg-6 d-flex justify-content-center align-items-center" data-aos="fade-up">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="{{ asset('assets/gambar/herry.jpg') }}" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Herry Sastrawan, S.IP., M.Si.</h4>
                                <span>Kasubbag Administrasi Umum</span>
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
                </div>
                <hr>
                <div class="row gy-4">
                    <div class="col-lg-4" data-aos="fade-up">
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

                    <div class="col-lg-4" data-aos="fade-up">
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

                    <div class="col-lg-4" data-aos="fade-up">
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

                    <div class="col-lg-4" data-aos="fade-up">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="{{ asset('assets/gambar/placeholder.jpg') }}" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Ramli Morales, S.T.</h4>
                                <span>Staf Driver</span>
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
                    <div class="col-lg-4" data-aos="fade-up">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="{{ asset('assets/gambar/placeholder.jpg') }}" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Zaenal Abidin, S.T.</h4>
                                <span>Staf MEP</span>
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
                    <div class="col-lg-4" data-aos="fade-up">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="{{ asset('assets/gambar/placeholder.jpg') }}" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Rizhki P. Dwi Putra, S.Kom.</h4>
                                <span>Staf TIK</span>
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

    </main><!-- End #main -->
@endsection
