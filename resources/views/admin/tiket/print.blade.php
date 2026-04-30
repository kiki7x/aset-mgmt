<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tiket Service Desk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 24px;
            color: #222;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .header-left {
            text-align: center;
            width: 100%;
        }

        .header-left h1,
        .header-left h2,
        .header-left p {
            margin: 0;
            line-height: 1.2;
        }

        .header-left h1 {
            font-size: 18px;
        }

        .header-left h2 {
            font-size: 16px;
        }

        .header-left p {
            font-size: 12px;
        }

        .header-right img {
            max-width: 140px;
            height: auto;
            display: block;
        }

        .divider {
            border-top: 2px solid #000;
            margin: 12px 0 20px;
        }

        .report-title {
            text-align: center;
            margin-bottom: 18px;
        }

        .report-info {
            margin-bottom: 16px;
            font-size: 13px;
        }

        .report-info strong {
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 24px;
        }

        table th,
        table td {
            border: 1px solid #444;
            padding: 8px 10px;
            vertical-align: top;
        }

        table th {
            background: #f4f4f4;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .small {
            font-size: 11px;
        }

        @media print {
            body {
                margin: 0.5cm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <h1>KEMENTERIAN PARIWISATA REPUBLIK INDONESIA</h1>
            <h2>POLITEKNIK PARIWISATA LOMBOK</h2>
            <p>Jalan Raden Puguh No. 1, Puyung, Jonggat, Praya, Lombok Tengah, Provinsi Nusa Tenggara Barat 83561</p>
            <p>Telp. (+62-0370) 6158029; Faksimile (+62 0370) 6158030</p>
            <p>Laman: www.ppl.ac.id • Posel: info@ppl.ac.id</p>
        </div>
        <div class="header-right">
            <img src="{{ asset('ppl-icon.png') }}" alt="Politeknik Pariwisata Lombok">
        </div>
    </div>

    <div class="divider"></div>

    <div class="report-title">
        <h2>Laporan Tiket Service Desk</h2>
        <p class="small">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
    </div>

    @if(!empty($search))
        <div class="report-info">
            <strong>Filter pencarian:</strong> {{ $search }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tiket</th>
                <th>Pemohon</th>
                <th>Jenis & Bidang</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th class="text-center">Prioritas</th>
                <th class="text-center">Status</th>
                <th class="text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $ticket->ticket }}</td>
                    <td>{{ $ticket->nama }}</td>
                    <td>{{ $ticket->issuetype }} - {{ $ticket->department }}</td>
                    <td>{{ $ticket->subject }}</td>
                    <td>{{ $ticket->description }}</td>
                    <td class="text-center">{{ $ticket->priority }}</td>
                    <td class="text-center">{{ $ticket->status }}</td>
                    <td class="text-center">{{ $ticket->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="small">Ini adalah laporan hasil cetak. Gunakan opsi Save as PDF atau Print di browser Anda untuk menyimpan sebagai file PDF.</div>

    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>
