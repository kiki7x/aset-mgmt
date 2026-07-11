<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lisensi</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; margin: 20px; color: #000; line-height: 1.5; }
        .header { display: flex; justify-content: space-between; align-items: center; gap: 20px; padding: 12px 0 16px; border-bottom: 2px solid #000; margin-bottom: 18px; }
        .header-left, .header-right { width: 110px; min-width: 110px; }
        .header-left img, .header-right img { max-width: 110px; height: auto; display: block; margin: 0 auto; }
        .header-center { text-align: center; flex: 1; padding: 0 12px; }
        .line1 { font-size: 14px; font-weight: 800; text-transform: uppercase; }
        .line2 { font-size: 16px; font-weight: 900; text-transform: uppercase; }
        .line3, .line4, .line5 { font-size: 12px; margin: 0; }
        .report-title { text-align: center; text-decoration: underline; margin-bottom: 18px; }
        .report-info { font-size: 13px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 24px; }
        table th, table td { border: 1px solid #444; padding: 6px 8px; vertical-align: top; }
        table th { background: #f4f4f4; text-align: center; }
        .text-center { text-align: center; }
        .report-footer { margin-top: 10pt; font-size: 12px; }
        .report-footer table tr td { border: none; }
        @media print { body { margin: 0.5cm; } }
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

    <div class="report-title"><h2>Daftar Lisensi</h2></div>

    @if (!empty($filterLabels))
        <div class="report-info">
            @foreach ($filterLabels as $label)
                <strong>{{ $label }}</strong><br>
            @endforeach
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tag</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Serial</th>
                <th>Seats</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($licenses as $license)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $license->tag }}</td>
                    <td>{{ $license->name }}</td>
                    <td>{{ optional($license->category)->name ?? '-' }}</td>
                    <td>{{ optional($license->supplier)->name ?? '-' }}</td>
                    <td>{{ $license->serial ?? '-' }}</td>
                    <td class="text-center">{{ $license->seats ?? '-' }}</td>
                    <td>{{ optional($license->status)->name ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center">Data tidak ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="report-footer">
        <table>
            <tr><td width="20%"><strong>Generate dari</strong></td><td width="1%">:</td><td>{{ config('app.name') }} {{ config('app.url') }}</td></tr>
            <tr><td width="20%"><strong>Tanggal cetak</strong></td><td width="1%">:</td><td>{{ date('d F Y H:i') }}</td></tr>
        </table>
    </div>

    <script>window.addEventListener('load', function() { window.print(); });</script>
</body>
</html>
