@extends('layouts.front', ['title' => 'SAPA PPL'])

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
                        <p>SAPA PPL hadir untuk mengoptimalkan pengelolaan aset di Poltekpar Lombok. Sistem ini menyediakan platform terpusat untuk memantau utilisasi aset, mengelola jadwal pemeliharaan secara proaktif, dan merespons laporan gangguan pada sarana
                            TIK serta Peralatan Rumah Tangga secara efisien.</p>
                        <div class="d-flex">
                            <a href="{{ route('login') }}" class="btn-get-started">Mulai</a>
                            <a href="{{ asset('assets/Video Profile sapa.ppl.ac.id.mp4') }}" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Tonton Video</span></a>
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

        <!-- About Section -->
        <section id="profil" class="about section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Profil</h2>
            </div><!-- End Section Title -->
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            Sistem Pengelolaan Aset Poltekpar Lombok dikembangkan untuk mengotomasi proses pengelolaan Barang Milik Negara (BMN) dan mendokumentasikannya secara digital agar menjadi lebih akurat, cepat, dan efisien. Berbasis web, platform ini
                            dirancang untuk menyajikan informasi pengelolaan secara real-time sekaligus menyediakan sistem monitoring yang terpusat.
                        </p>
                        <ul>
                            <li><i class="bi bi-check2-circle"></i> <span>Pendataan Aset Poltekpar Lombok</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Pemeliharaan Aset Poltekpar Lombok</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Lacak Aset Poltekpar Lombok</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Helpdesk sarana dan prasarana berbaris ticket</span></li>
                        </ul>
                    </div>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <p>Kehadiran platform ini merupakan langkah strategis dalam meminimalisir risiko kerusakan fasilitas dan mempercepat penanganan kendala di lapangan. Integrasi teknologi di dalamnya tidak hanya menyederhanakan birokrasi internal, tetapi juga
                            meningkatkan mutu pelayanan sarana prasarana secara berkelanjutan.</p>
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
                            <div class="icon"><i class="fa-regular fa-handshake"></i></div>
                            <h4><a href="" class="stretched-link">Peminjaman Ruangan dan Barang</a></h4>
                            <p>Kelola dan ajukan peminjaman fasilitas serta inventaris dengan lebih mudah. Cek ketersediaan secara real-time, ajukan izin secara digital, dan pantau status persetujuan dalam satu sarana terpadu.</p>
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

        <!-- Recent Blog Postst Section -->
        <section id="recent-blog-postst" class="recent-blog-postst section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Pusat Pengetahuan</h2>
                <p>Artikel panduan dan dokumentasi untuk membantu pengguna memanfaatkan aset di lingkungan Poltekpar Lombok.</p>
            </div><!-- End Section Title -->
            <div class="container">
                <div class="row">
                    @foreach ($articles as $article)
                        <div class="col-xl-4 col-md-6">
                            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">
                                <div class="post-img position-relative overflow-hidden">
                                    <img src="{{ $article->featured_image_url ?? asset('arsha/assets/img/news-placeholder.jpg') }}" class="card-img-top" alt="" style="object-fit:cover; height:250px;">
                                    <span class="post-date">{{ $article->created_at->format('F d') }}</span>
                                </div>
                                <div class="post-content d-flex flex-column">
                                    <h3 class="post-title">{{ $article->title }}</h3>
                                    <div class="meta d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person"></i> <span class="ps-2">{{ $article->author->name ?? 'Poltekpar' }}</span>
                                        </div>
                                        <span class="px-3 text-black-50">/</span>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-folder2"></i> <span class="ps-2">{{ $article->category->name ?? 'Uncategorized' }}</span>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <p class="card-text" style="flex:1">{{ Str::limit(strip_tags($article->content), 140) }}</p>
                                    <a href="{{ route('knowledge-base.show', $article->slug) }}" class="readmore stretched-link"><span>Selengkapnya</span><i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div><!-- End post item -->
                    @endforeach
                </div>
                <div class="text-center mt-4" data-aos="fade-up">
                    <a href="{{ route('knowledge-base') }}" class="btn btn-primary">Selengkapnya <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

        </section><!-- /Recent Blog Postst Section -->

        <!-- Skills Section -->
        <section id="statistik" class="skills section light-background">
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
                <p>Didukung oleh personil yang berdedikasi dan kompeten di bidangnya untuk memastikan pengelolaan, pemeliharaan, dan pelayanan aset sarana prasarana berjalan secara optimal.</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4 justify-content-center">

                    <div class="col-lg-6 d-flex justify-content-center align-items-center" data-aos="fade-up">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="{{ asset('assets/gambar/herry.jpg') }}" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Herry Sastrawan, S.IP., M.Si.</h4>
                                <span>Kasubbag Administrasi Umum</span>
                                <p>Bertanggung jawab atas koordinasi menyeluruh administrasi, tata usaha, dan manajemen fasilitas organisasi.</p>
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
                                <p>Fokus pada standardisasi pendataan, inventarisasi, dan legalitas Barang Milik Negara.</p>
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
                                <p>Mengawasi pemeliharaan fisik, kebersihan, dan kesiapan operasional sarana prasarana harian.</p>
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
                                <p>Memastikan keandalan sistem informasi, jaringan, dan infrastruktur digital pendukung aplikasi."</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <hr>

                    <div class="col-lg-4" data-aos="fade-up">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="{{ asset('assets/gambar/placeholder.jpg') }}" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Ramli</h4>
                                <span>Staf Driver</span>
                                <p>Bertanggung jawab atas operasional, keselamatan, dan pemeliharaan rutin kendaraan dinas guna mendukung mobilitas dan kelancaran tugas logistik organisasi.</p>
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
                                <h4>Zaenal Abidin</h4>
                                <span>Staf MEP</span>
                                <p>Mengelola dan memastikan seluruh sistem mekanikal, kelistrikan, serta instalasi air di lingkungan gedung dan fasilitas organisasi berfungsi dengan aman dan optimal.</p>
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
                                <p>Menangani dukungan teknis, pemeliharaan infrastruktur jaringan, serta memastikan keamanan dan ketersediaan sistem informasi/aplikasi operasional harian.</p>
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
        <section id="faq" class="faq-2 section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Frequently Asked Questions</h2>
                <p>Temukan jawaban atas pertanyaan yang paling sering diajukan mengenai penggunaan, fitur, dan sistem pelaporan aplikasi SAPA PPL di bawah ini.</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="faq-container">
                            <div class="faq-item faq-active" data-aos="fade-up" data-aos-delay="200">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Apa itu aplikasi SAPA PPL?</h3>
                                <div class="faq-content">
                                    <p>SAPA PPL adalah platform digital terintegrasi yang dirancang untuk mempermudah manajemen aset organisasi, mulai dari pendataan, pemeliharaan berkala, pelacakan posisi aset via QR Code, hingga sistem pelaporan kerusakan
                                        fasilitas berbasis tiket.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Bagaimana cara melaporkan kerusakan sarana atau prasarana?</h3>
                                <div class="faq-content">
                                    <p>Anda dapat masuk ke menu Service Desk, lalu buat tiket laporan baru. Isi detail kerusakan, lokasi fasilitas, dan unggah foto pendukung. Setelah dikirim, Anda dapat memantau status penanganan oleh tim teknisi secara langsung
                                        melalui aplikasi.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Siapa saja yang bisa menggunakan fitur Lacak Aset?</h3>
                                <div class="faq-content">
                                    <p>Fitur ini dapat digunakan oleh petugas inventaris maupun pengguna umum yang memiliki akses. Cukup gunakan kamera perangkat Anda untuk memindai QR Code yang tertempel pada fisik aset untuk melihat informasi detail, status, dan
                                        riwayat mutasinya.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Bagaimana jika aset yang saya cari tidak terdaftar di sistem?</h3>
                                <div class="faq-content">
                                    <p>Hal ini bisa terjadi jika aset tersebut belum diinput oleh tim logistik. Silakan hubungi admin atau gunakan fitur Pendataan Aset (jika akun Anda memiliki hak akses) untuk mendaftarkan aset baru beserta spesifikasinya ke dalam
                                        basis data.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Apa fungsi dari menu Pusat Pengetahuan?</h3>
                                <div class="faq-content">
                                    <p>Pusat Pengetahuan (Knowledge Center) berisi panduan teks dan video mengenai cara penggunaan aplikasi, Standar Operasional Prosedur (SOP) perawatan fasilitas, serta tips penanganan pertama pada kendala teknis ringan sebelum
                                        teknisi tiba.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Faq 2 Section -->

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
                    {{-- <div class="swiper-wrapper align-items-center">
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
                    </div> --}}
                </div>
            </div>
        </section><!-- /Clients Section -->
    </main>
@endsection

@push('script-foot')
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
