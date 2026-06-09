@extends('layouts.auth', ['title' => 'Login - SAPA PPL'])

@section('content')
    <div class="col-lg-6 col-md-10 col-sm-10 text-center">
        <div class="card border-0 shadow rounded">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <a href="{{ url('/') }}">
                    <img class="rounded img-fluid" loading="lazy" src="{{ asset('ppl-icon.png') }}" alt="logo ppl">
                </a>
                <h4 class="font-weight-bold">LOGIN</h4>
                <hr>
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold text-uppercase mb-n2">Email address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control text-center @error('email') is-invalid @enderror" placeholder="Masukkan Alamat Email">
                        @error('email')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-uppercase mb-n2">Password</label>
                        <input type="password" name="password" class="form-control text-center @error('password') is-invalid @enderror" placeholder="Masukkan Password">
                        @error('password')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group text-center">
                        <label class="font-weight-bold text-uppercase w-100">Verifikasi Captcha</label>
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <img
                                id="login-captcha-image"
                                src="{{ route('captcha.image', ['for' => 'login']) }}"
                                alt="Captcha"
                                style="height: 52px; border: 1px solid #ced4da; border-radius: 4px; background: #eef1f4;">
                            <button type="button" class="btn btn-outline-secondary ms-2" id="refresh-login-captcha-btn" title="Muat ulang captcha">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <input type="text" name="captcha" id="login-captcha" class="form-control w-100 text-center @error('captcha') is-invalid @enderror" placeholder="Captcha" maxlength="6" autocomplete="off" style="text-transform: uppercase;">
                        @error('captcha')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">LOGIN</button>
                    <hr>
                    <a href="/forgot-password">Lupa Password ?</a>
                    <div class="register mt-3 text-center">
                        <p>Belum punya akun ? Daftar <a href="{{ route('register') }}">Disini</a></p>
                        <p><a href="{{ route('/')}}">← Kembali ke Home </a></p>
                    </div>
                </form>
            </div>
            <div class="alert alert-primary mx-auto my-6 large">
                <strong><u>INFO PENTING <i class="fas fa-exclamation"></i></u></strong>
                <p class="text-center my-2 py-0"> Lindungi akun Anda dengan tidak memberikan ID pengguna dan kata sandi Anda pada siapapun. Segala risiko akibat penyalahgunaan ID pengguna menjadi tanggung jawab pengguna sepenuhnya. </p>
                <p class="text-center my-2 py-0"> Kami menjamin kerahasiaan data setiap pengguna sebagai bentuk penghargaan kami terhadap privasi pengguna. </p>
            </div>
        </div>
    </div>

    @push('script-foot')
    <script>
        function refreshLoginCaptchaImage() {
            $.ajax({
                url: '{{ route("refresh.captcha", ["for" => "login"]) }}',
                type: 'GET',
                success: function(response) {
                    if (response.success && response.captcha_url) {
                        $('#login-captcha-image').attr('src', response.captcha_url);
                        $('#login-captcha').val('').focus();
                    }
                },
                error: function() {
                    alert('Gagal memperbarui captcha');
                }
            });
        }

        $('#refresh-login-captcha-btn').on('click', function() {
            refreshLoginCaptchaImage();
        });

        $('#login-captcha').on('input', function() {
            this.value = this.value.toUpperCase();
        });
    </script>
    @endpush
@endsection
