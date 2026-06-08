@extends('layouts.front', ['title' => 'FAQ - SAPA PPL'])

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
                        <li class="current">Faq</li>
                    </ol>
                </nav>
                {{-- <h1>Layanan</h1> --}}
            </div>
        </div><!-- End Page Title -->

        <!-- Faq 2 Section -->
        <section id="faq-2" class="faq-2 section light-background">

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
                                    <p>SAPA PPL adalah platform digital terintegrasi yang dirancang untuk mempermudah manajemen aset organisasi, mulai dari pendataan, pemeliharaan berkala, pelacakan posisi aset via QR Code, hingga sistem pelaporan kerusakan fasilitas berbasis tiket.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Bagaimana cara melaporkan kerusakan sarana atau prasarana?</h3>
                                <div class="faq-content">
                                    <p>Anda dapat masuk ke menu Service Desk, lalu buat tiket laporan baru. Isi detail kerusakan, lokasi fasilitas, dan unggah foto pendukung. Setelah dikirim, Anda dapat memantau status penanganan oleh tim teknisi secara langsung melalui aplikasi.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Siapa saja yang bisa menggunakan fitur Lacak Aset?</h3>
                                <div class="faq-content">
                                    <p>Fitur ini dapat digunakan oleh petugas inventaris maupun pengguna umum yang memiliki akses. Cukup gunakan kamera perangkat Anda untuk memindai QR Code yang tertempel pada fisik aset untuk melihat informasi detail, status, dan riwayat mutasinya.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Bagaimana jika aset yang saya cari tidak terdaftar di sistem?</h3>
                                <div class="faq-content">
                                    <p>Hal ini bisa terjadi jika aset tersebut belum diinput oleh tim logistik. Silakan hubungi admin atau gunakan fitur Pendataan Aset (jika akun Anda memiliki hak akses) untuk mendaftarkan aset baru beserta spesifikasinya ke dalam basis data.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                                <i class="faq-icon bi bi-question-circle"></i>
                                <h3>Apa fungsi dari menu Pusat Pengetahuan?</h3>
                                <div class="faq-content">
                                    <p>Pusat Pengetahuan (Knowledge Center) berisi panduan teks dan video mengenai cara penggunaan aplikasi, Standar Operasional Prosedur (SOP) perawatan fasilitas, serta tips penanganan pertama pada kendala teknis ringan sebelum teknisi tiba.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Faq 2 Section -->

    </main><!-- End #main -->
@endsection
