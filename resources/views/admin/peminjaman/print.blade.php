<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Peminjaman Aset #{{ $borrowing->id }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; margin: 20px; color: #000; line-height: 1.5; }
        .header { display: flex; justify-content: space-between; align-items: center; gap: 20px; padding: 12px 0 16px; border-bottom: 2px solid #000; margin-bottom: 18px; }
        .header-left, .header-right { width: 110px; min-width: 110px; }
        .header-left img, .header-right img { max-width: 110px; height: auto; display: block; margin: 0 auto; }
        .header-center { text-align: center; flex: 1; padding: 0 12px; }
        .header-center h1, .header-center h2, .header-center p { margin: 0; line-height: 1.2; }
        .line1 { font-size: 14px; font-weight: 800; text-transform: uppercase; }
        .line2 { font-size: 16px; font-weight: 900; text-transform: uppercase; }
        .line3, .line4, .line5 { font-size: 12px; margin: 0; }
        .report-title { text-align: center; text-decoration: underline; margin-bottom: 18px; }
        table.info-table { width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 24px; }
        table.info-table td { padding: 4px 8px; vertical-align: top; }
        table.info-table td:first-child { width: 200px; font-weight: bold; }
        table.info-table td:nth-child(2) { width: 10px; }
        table.data-table { width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 24px; }
        table.data-table th, table.data-table td { border: 1px solid #444; padding: 6px 8px; vertical-align: top; }
        table.data-table th { background: #f4f4f4; text-align: center; }
        .text-center { text-align: center; }
        .report-footer { margin-top: 10pt; font-size: 12px; }
        .report-footer table tr td { border: none; }
        .signature { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature-block { text-align: center; width: 200px; }
        .signature-block .line { border-bottom: 1px solid #000; margin-top: 60px; margin-bottom: 4px; }
        .photo-section { margin-top: 20px; text-align: center; }
        .photo-section img { max-width: 300px; max-height: 250px; border: 1px solid #ccc; }
        @media print { body { margin: 0.5cm; } .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left"><img src="{{ asset('menpar.png') }}"></div>
        <div class="header-center">
            <div class="line1">KEMENTERIAN PARIWISATA REPUBLIK INDONESIA</div>
            <div class="line2">POLITEKNIK PARIWISATA LOMBOK</div>
            <div class="line3">Jalan Raden Puguh No. 1, Puyung, Jonggat,<br>Praya, Lombok Tengah, Provinsi Nusa Tenggara Barat 83561</div>
            <div class="line4">Telepon (+62-0370) 6158029; Faksimile (+62 0370) 6158030</div>
            <div class="line5">Laman: www.ppl.ac.id Posel: info@ppl.ac.id</div>
        </div>
        <div class="header-right"><img src="{{ asset('ppl-icon.png') }}"></div>
    </div>

    <div class="report-title"><h2>BUKTI PEMINJAMAN ASET</h2></div>

    <table class="info-table">
        <tr>
            <td>No. Peminjaman</td>
            <td>:</td>
            <td>{{ $borrowing->id }}</td>
        </tr>
        <tr>
            <td>Jenis Peminjaman</td>
            <td>:</td>
            <td>{{ ucfirst($borrowing->type) }}</td>
        </tr>
        @if ($borrowing->type === 'ruangan' && $borrowing->location)
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td>{{ $borrowing->location->name }} ({{ $borrowing->location->building?->name ?? '-' }} Lt {{ $borrowing->location->floor ?? '-' }})</td>
        </tr>
        @endif
        @if ($borrowing->type === 'barang' && $borrowing->asset)
        <tr>
            <td>Barang</td>
            <td>:</td>
            <td>{{ $borrowing->asset->name }} ({{ $borrowing->asset->tag }})</td>
        </tr>
        @endif
        <tr>
            <td>Nama Peminjam</td>
            <td>:</td>
            <td>{{ $borrowing->borrower_name }}</td>
        </tr>
        @if ($borrowing->borrower_nip)
        <tr>
            <td>NIP/NIK</td>
            <td>:</td>
            <td>{{ $borrowing->borrower_nip }}</td>
        </tr>
        @endif
        @if ($borrowing->borrower_unit)
        <tr>
            <td>Unit/Instansi</td>
            <td>:</td>
            <td>{{ $borrowing->borrower_unit }}</td>
        </tr>
        @endif
        <tr>
            <td>Tanggal Mulai</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($borrowing->borrow_start)->format('d F Y H:i') }}</td>
        </tr>
        <tr>
            <td>Tanggal Akhir</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($borrowing->borrow_end)->format('d F Y H:i') }}</td>
        </tr>
        @if ($borrowing->return_date)
        <tr>
            <td>Tanggal Pengembalian</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($borrowing->return_date)->format('d F Y H:i') }}</td>
        </tr>
        @endif
        <tr>
            <td>Tujuan Peminjaman</td>
            <td>:</td>
            <td>{{ $borrowing->purpose }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $borrowing->status === 'dipinjam' ? 'DIPINJAM' : 'DIKEMBALIKAN' }}</td>
        </tr>
        @if ($borrowing->notes)
        <tr>
            <td>Catatan</td>
            <td>:</td>
            <td>{{ $borrowing->notes }}</td>
        </tr>
        @endif
        <tr>
            <td>Dibuat Oleh</td>
            <td>:</td>
            <td>{{ $borrowing->creator?->fullname ?? '-' }}</td>
        </tr>
    </table>

    @if ($borrowing->borrower_photo || $borrowing->return_photo)
    <div class="photo-section">
        @if ($borrowing->borrower_photo)
        <div style="display:inline-block; margin-right: 20px;">
            <strong>Foto Peminjaman</strong><br>
            <img src="{{ asset('storage/' . $borrowing->borrower_photo) }}" alt="Foto Peminjaman">
        </div>
        @endif
        @if ($borrowing->return_photo)
        <div style="display:inline-block; margin-left: 20px;">
            <strong>Foto Pengembalian</strong><br>
            <img src="{{ asset('storage/' . $borrowing->return_photo) }}" alt="Foto Pengembalian">
        </div>
        @endif
    </div>
    @endif

    <div class="signature">
        <div class="signature-block">
            <div class="line"></div>
            <small>Peminjam</small>
        </div>
        <div class="signature-block">
            <div class="line"></div>
            <small>Petugas</small>
        </div>
    </div>

    <div class="report-footer" style="margin-top: 30px;">
        <table>
            <tr><td width="20%"><strong>Generate dari</strong></td><td width="1%">:</td><td>{{ config('app.name') }} {{ config('app.url') }}</td></tr>
            <tr><td width="20%"><strong>Tanggal cetak</strong></td><td width="1%">:</td><td>{{ date('d F Y H:i') }}</td></tr>
        </table>
    </div>

    <script>window.addEventListener('load', function() { window.print(); });</script>
</body>
</html>
