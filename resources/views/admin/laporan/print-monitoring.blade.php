<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Monitoring</title>
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
        .report-info { font-size: 13px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 24px; }
        table th, table td { border: 1px solid #444; padding: 6px 8px; vertical-align: top; }
        table th { background: #f4f4f4; text-align: center; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .report-footer { margin-top: 10pt; font-size: 12px; }
        .report-footer table tr td { border: none; }
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

    <div class="report-title"><h2>Laporan Monitoring</h2></div>

    @if (!empty($filterLabels))
        <div class="report-info">
            @foreach ($filterLabels as $label)
                <strong>{{ $label }}</strong><br>
            @endforeach
        </div>
    @endif

    @php
        $totalMonitor = count($rekap);
        $totalCek = array_sum(array_column($rekap, 'total'));
        $totalUp = array_sum(array_column($rekap, 'up'));
        $globalUptime = $totalCek > 0 ? round(($totalUp / $totalCek) * 100, 2) : 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Monitor</th>
                <th>Jenis</th>
                <th>URL</th>
                <th>Status Terakhir</th>
                <th>Total Cek</th>
                <th>Up</th>
                <th>Down</th>
                <th>Uptime %</th>
                <th>Avg Response (ms)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekap as $row)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $row['name'] }}</td>
                    <td class="text-center">{{ $row['type'] }}</td>
                    <td>{{ $row['url'] }}</td>
                    <td class="text-center">{{ $row['last_status'] === '-' ? '-' : strtoupper($row['last_status']) }}</td>
                    <td class="text-center">{{ $row['total'] }}</td>
                    <td class="text-center">{{ $row['up'] }}</td>
                    <td class="text-center">{{ $row['down'] }}</td>
                    <td class="text-center">{{ $row['uptime'] }}%</td>
                    <td class="text-right">{{ $row['avg_response'] ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="10" class="text-center">Data tidak ditemukan.</td></tr>
            @endforelse
            @if ($totalCek > 0)
                <tr>
                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                    <td class="text-center"><strong>{{ $totalMonitor }} monitor</strong></td>
                    <td class="text-center"><strong>{{ $totalCek }}</strong></td>
                    <td class="text-center"><strong>{{ $totalUp }}</strong></td>
                    <td class="text-center"><strong>{{ $totalCek - $totalUp }}</strong></td>
                    <td class="text-center"><strong>{{ $globalUptime }}%</strong></td>
                    <td></td>
                </tr>
            @endif
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
