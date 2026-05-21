@extends('layouts.front', ['title' => 'Lacak - SAPA PPL'])

{{-- @section('title', 'Kelola Aset TIK') --}}
{{-- <x-slot:title>{{ $title }}</x-slot:title> --}}

@push('script-head')
<style>
    #video-container {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        border: 1px solid #ccc;
    }
    #qr-canvas {
        display: none;
    }
</style>
@endpush

@section('content')
<main class="main">
<!-- Hero Section -->
<section id="hero" class="hero section dark-background">
    <div class="container">
        {{-- <div class="row gy-4">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                <h1>Sistem Aplikasi Pengelolaan Aset Poltekpar Lombok</h1>
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
        </div> --}}

        <div class="container section-title" data-aos="fade-up">
            <h2><i class="bi bi-qr-code-scan"></i> Lacak Aset</h2>
            <p>Fitur lacak aset dengan scan QR Code</p>
        </div><!-- End Section Title -->
    
        <div class="container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Scan QR Code</div>
                            <div class="card-body">
                                <div id="video-container">
                                    <video id="qr-video" width="100%" autoplay></video>
                                </div>
                                <canvas id="qr-canvas" style="display:none;"></canvas>
                                <div id="qr-result" class="mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /Hero Section -->

</main>
@endsection


@push('script-foot')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script>
    const video = document.getElementById('qr-video');
    const canvas = document.getElementById('qr-canvas');
    const canvasContext = canvas.getContext('2d');
    const qrResultDiv = document.getElementById('qr-result');

    function startScanning() {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(function(stream) {
                video.srcObject = stream;
                video.play();
                requestAnimationFrame(scan);
            })
            .catch(function(error) {
                console.error('Could not access the camera.', error);
                alert('Tidak dapat menggunakan fitur Scan QR Code. \nPastikan setting izin/allow Camera pada browser anda.');
            });
    }

    function scan() {
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.height = video.videoHeight;
            canvas.width = video.videoWidth;
            canvasContext.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvasContext.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: 'dontInvert',
            });

            if (code) {
                console.log('QR Code detected:', code.data);
                // Asumsi data QR code berisi ID barang
                window.location.href = `/lacak/show/${code.data}`;
                return; // Stop scanning setelah berhasil
            }
        }
        requestAnimationFrame(scan);
    }

    window.onload = startScanning;
</script>
@endpush