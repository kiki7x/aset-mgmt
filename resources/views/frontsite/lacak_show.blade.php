@extends('layouts.front', ['title' => 'Lacak - SAPA PPL'])

@push('script-head')
<style>
    .lacak-result .card {
        margin-bottom: 18px;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
    }
    .lacak-result .card-header {
        background-color: #e9ecef;
        font-weight: 600;
        border-bottom: 1px solid #dee2e6;
    }
    .lacak-result .table th {
        width: 38%;
    }
    .status-badge {
        font-size: 0.95rem;
        padding: 0.4em 0.9em;
        border-radius: 0.375rem;
        color: #fff;
    }
    .asset-image {
        max-height: 200px;
        object-fit: contain;
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
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

    <div class="container lacak-result" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($asset)
                    <div class="alert alert-success text-center" role="alert">
                        <i class="bi bi-check-circle-fill me-1"></i> Aset ditemukan!
                        <br><small class="text-muted">Kode/Tag: <strong>{{ $asset->tag }}</strong></small>
                    </div>

                    {{-- Identitas Barang --}}
                    <div class="card">
                        <div class="card-header"><i class="bi bi-box-seam me-1"></i> Identitas Barang</div>
                        <div class="card-body">
                            @if ($asset->image)
                                <div class="text-center mb-3">
                                    <img src="{{ asset('storage') }}/{{ $asset->image }}" alt="Foto Aset" class="asset-image">
                                </div>
                            @endif
                            <table class="table table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Kode Barang (Tag)</th>
                                        <td>{{ $asset->tag }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nama Barang</th>
                                        <td>{{ $asset->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Klasifikasi</th>
                                        <td>{{ optional($asset->classification)->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Kategori</th>
                                        <td>{{ optional($asset->category)->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Merk / Pabrikan</th>
                                        <td>{{ optional($asset->manufacturer)->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Model</th>
                                        <td>{{ optional($asset->model)->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">No. Seri</th>
                                        <td>{{ $asset->serial ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Supplier</th>
                                        <td>{{ optional($asset->supplier)->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tanggal Perolehan</th>
                                        <td>{{ $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->translatedFormat('d F Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Garansi</th>
                                        <td>{{ $asset->warranty_months ? $asset->warranty_months . ' bulan' : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pemilik & Pengelola --}}
                    <div class="card">
                        <div class="card-header"><i class="bi bi-person-vcard me-1"></i> Pemilik & Pengelola</div>
                        <div class="card-body">
                            <table class="table table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Satuan Kerja</th>
                                        <td>POLITEKNIK PARIWISATA LOMBOK</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Pengelola</th>
                                        <td>{{ optional($asset->admin)->fullname ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Pengguna</th>
                                        <td>{{ optional($asset->user)->fullname ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Lokasi</th>
                                        <td>
                                            @if ($asset->location)
                                                {{ $asset->location->name }}
                                                @if ($asset->location->building)
                                                    ({{ $asset->location->building->name }}{{ $asset->location->floor ? ' - Lt ' . $asset->location->floor : '' }})
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Status & Kondisi --}}
                    <div class="card">
                        <div class="card-header"><i class="bi bi-clipboard-check me-1"></i> Status & Kondisi</div>
                        <div class="card-body">
                            @if ($asset->status)
                                <div class="mb-3">
                                    <span class="status-badge" style="background-color: {{ $asset->status->color ?? '#6c757d' }};">
                                        {{ $asset->status->name }}
                                    </span>
                                </div>
                            @endif

                            @if ($borrowing)
                                <div class="alert alert-warning py-2 mb-3">
                                    <strong><i class="bi bi-exclamation-triangle-fill me-1"></i> Sedang Dipinjam</strong>
                                    <ul class="mb-0 mt-1">
                                        <li>Peminjam: {{ $borrowing->borrower_name ?: optional($borrowing->user)->fullname ?: '-' }}</li>
                                        <li>Periode: {{ \Carbon\Carbon::parse($borrowing->borrow_start)->translatedFormat('d M Y H:i') }} s/d {{ \Carbon\Carbon::parse($borrowing->borrow_end)->translatedFormat('d M Y H:i') }}</li>
                                        @if ($borrowing->purpose)
                                            <li>Tujuan: {{ $borrowing->purpose }}</li>
                                        @endif
                                    </ul>
                                </div>
                            @else
                                <p class="mb-2"><i class="bi bi-check-circle me-1 text-success"></i> Tidak sedang dipinjam.</p>
                            @endif

                            @if ($schedule)
                                <div class="alert alert-info py-2 mb-0">
                                    <strong><i class="bi bi-calendar-event me-1"></i> Jadwal Pemeliharaan Terdekat</strong>
                                    <ul class="mb-0 mt-1">
                                        <li>{{ $schedule->name }}</li>
                                        <li>{{ \Carbon\Carbon::parse($schedule->start)->translatedFormat('d F Y') }}</li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger text-center" role="alert">
                        <i class="bi bi-x-circle-fill me-1"></i> Aset tidak ditemukan!
                        <br><small>Pastikan QR Code yang dipindai terdaftar di sistem, atau periksa kembali kode aset.</small>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('lacak') }}" class="btn btn-primary"><i class="bi bi-qr-code-scan me-1"></i> Pindai Lagi</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
</main>
@endsection

@push('script-foot')
@endpush
