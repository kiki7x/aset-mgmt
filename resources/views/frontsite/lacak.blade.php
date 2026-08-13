@extends('layouts.front', ['title' => 'Lacak - SAPA PPL'])

@push('script-head')
<style>
    #video-container {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        background: #000;
    }
    #qr-video {
        display: block;
        width: 100%;
    }
    #qr-canvas {
        display: none;
    }
    #scan-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        z-index: 5;
    }
    #scan-overlay::before {
        content: "";
        position: absolute;
        left: 10%;
        right: 10%;
        top: 0;
        bottom: 0;
        border: 3px solid rgba(255, 255, 255, 0.85);
        border-top: none;
        border-bottom: none;
        border-radius: 4px;
    }
    #scan-frame {
        position: absolute;
        left: 10%;
        right: 10%;
        height: 4px;
        background: #47b2e4;
        box-shadow: 0 0 12px rgba(71, 178, 228, 0.9);
        animation: scan-move 2.2s ease-in-out infinite;
    }
    @keyframes scan-move {
        0% { top: 10%; }
        50% { top: 88%; }
        100% { top: 10%; }
    }
    #scan-status {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        text-align: center;
        color: #fff;
        background: rgba(0, 0, 0, 0.55);
        padding: 4px 0;
        font-size: 0.9rem;
        z-index: 6;
    }
</style>
@endpush

@section('content')
<main class="main">
<section id="hero" class="hero section dark-background">
    <div class="container section-title" data-aos="fade-up">
        <h2><i class="bi bi-qr-code-scan"></i> Lacak Aset</h2>
        <p>Fitur lacak aset dengan scan QR Code</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Scan QR Code</div>
                    <div class="card-body">
                        <div id="scan-alert"></div>

                        <div id="video-container">
                            <video id="qr-video" width="100%" autoplay playsinline muted></video>
                            <div id="scan-overlay" style="display:none;">
                                <div id="scan-frame"></div>
                                <div id="scan-status">Memindai...</div>
                            </div>
                        </div>
                        <canvas id="qr-canvas" style="display:none;"></canvas>

                        <div class="text-center mt-3">
                            <button type="button" id="btn-toggle-scan" class="btn btn-primary">Mulai Scan</button>
                        </div>

                        <hr class="my-4">

                        <form id="form-manual" action="{{ route('lacak.show', 'tag') }}" method="GET" class="mt-3">
                            <label for="manual-tag" class="form-label">Tidak bisa scan? Masukkan kode aset (Tag) secara manual:</label>
                            <div class="input-group">
                                <input type="text" id="manual-tag" name="tag" class="form-control" placeholder="Contoh: SAPA-TIK-0001" required>
                                <button type="submit" class="btn btn-success"><i class="bi bi-search"></i> Lacak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
@endsection

@push('script-foot')
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script>
    const video = document.getElementById('qr-video');
    const canvas = document.getElementById('qr-canvas');
    const canvasContext = canvas.getContext('2d');
    const overlay = document.getElementById('scan-overlay');
    const statusEl = document.getElementById('scan-status');
    const alertBox = document.getElementById('scan-alert');
    const btnToggle = document.getElementById('btn-toggle-scan');
    const formManual = document.getElementById('form-manual');

    let scanning = false;
    let stream = null;
    let animationId = null;

    formManual.addEventListener('submit', function(e) {
        e.preventDefault();
        const tag = document.getElementById('manual-tag').value.trim();
        if (tag) {
            window.location.href = "{{ route('lacak.show', 'tag') }}".replace('/tag', '/' + encodeURIComponent(tag));
        }
    });

    function showMessage(message, type) {
        alertBox.innerHTML = '';
        const alert = document.createElement('div');
        alert.className = 'alert alert-' + type + ' alert-dismissible fade show';
        alert.setAttribute('role', 'alert');
        alert.innerHTML = message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        alertBox.appendChild(alert);
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(function(track) { track.stop(); });
            stream = null;
        }
        if (animationId) {
            cancelAnimationFrame(animationId);
            animationId = null;
        }
        video.srcObject = null;
        scanning = false;
        overlay.style.display = 'none';
        btnToggle.textContent = 'Mulai Scan';
        btnToggle.classList.remove('btn-danger');
        btnToggle.classList.add('btn-primary');
    }

    function startCamera() {
        stopCamera();
        showMessage('', '');
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
            .then(function(camStream) {
                stream = camStream;
                video.srcObject = stream;
                video.play();
                scanning = true;
                overlay.style.display = 'flex';
                btnToggle.textContent = 'Stop Scan';
                btnToggle.classList.remove('btn-primary');
                btnToggle.classList.add('btn-danger');
                requestAnimationFrame(scan);
            })
            .catch(function(error) {
                console.error('Could not access the camera.', error);
                showMessage(
                    'Tidak dapat mengakses kamera. Pastikan browser mengizinkan izin kamera, ' +
                    'atau gunakan pencarian manual di bawah.', 'danger'
                );
            });
    }

    function scan() {
        if (!scanning) return;

        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.height = video.videoHeight;
            canvas.width = video.videoWidth;
            canvasContext.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvasContext.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: 'dontInvert',
            });

            if (code) {
                const tag = String(code.data).trim();
                console.log('QR Code detected:', tag);
                statusEl.textContent = 'QR ditemukan, membuka detail...';
                stopCamera();
                if (tag) {
                    window.location.href = "{{ route('lacak.show', 'tag') }}".replace('/tag', '/' + encodeURIComponent(tag));
                } else {
                    showMessage('Kode QR tidak valid (kosong). Coba lagi.', 'warning');
                }
                return;
            }
        }
        animationId = requestAnimationFrame(scan);
    }

    btnToggle.addEventListener('click', function() {
        if (scanning) {
            stopCamera();
        } else {
            startCamera();
        }
    });

    window.addEventListener('beforeunload', stopCamera);
</script>
@endpush
