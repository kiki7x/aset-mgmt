@extends('layouts.backsite', [
    'title' => 'Access Denied | SAPA PPL',
    'welcome' => 'Access Denied',
    'breadcrumb' => '<li class="breadcrumb-item active">Access Denied</li>',
])

@section('content')
    <style>
        .error-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            flex-direction: column;
            text-align: center;
        }

        .img-vector {
            max-width: 400px;
            width: 100%;
            height: auto;
        }

        .error-title {
            font-size: 2rem;
            font-weight: bold;
            margin-top: 20px;
            color: #333;
        }

        .error-message {
            font-size: 1.2rem;
            color: #666;
            margin-top: 10px;
        }
    </style>

    <div class="error-container">
        <img class="img-vector" loading="lazy" src="{{ asset('assets/gambar/403-vector.png') }}" alt="403 Access Denied">
        <div class="error-title">403 - Akses Ditolak</div>
        <div class="error-message">Anda tidak memiliki izin untuk mengakses halaman ini.</div>
    </div>
@endsection
