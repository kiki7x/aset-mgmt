<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 20px;
            color: #000;
            line-height: 1.5;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 12px 0 16px;
            border-bottom: 2px solid #000;
            margin-bottom: 18px;
        }

        .header-left,
        .header-right {
            width: 110px;
            min-width: 110px;
        }

        .header-left img,
        .header-right img {
            max-width: 110px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .header-center {
            text-align: center;
            flex: 1;
            padding: 0 12px;
        }

        .header-center h1,
        .header-center h2,
        .header-center p {
            margin: 0;
            line-height: 1.2;
        }

        .line1 {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .line2 {
            font-size: 16px;
            font-weight: 900;
            margin-top: 8px;
            text-transform: uppercase;
        }

        .header-center p,
        .line3,
        .line4,
        .line5 {
            font-size: 12px;
            margin: 0;
        }

        .header-center p a {
            color: #000;
            text-decoration: none;
        }

        .divider {
            display: none;
        }
        
        .badge {
            display: inline;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            padding: 0;
            background: transparent;
            border-radius: 0;
        }

        .badge.priority-low { color: #6c757d; }
        .badge.priority-medium { color: #d39e00; }
        .badge.priority-high { color: #dc3545; }

        .badge.status-pending,
        .badge.status-proses,
        .badge.status-process { color: #d39e00; }
        .badge.status-open { color: #0d6efd; }
        .badge.status-in-progress { color: #0d6efd; }
        .badge.status-close,
        .badge.status-closed { color: #198754; }
        .badge.status-rejected,
        .badge.status-tolak { color: #dc3545; }
        .badge.status-completed,
        .badge.status-selesai { color: #198754; }

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
        <img src="{{ asset('menpar.png') }}">
    </div>

    <div class="header-center">
        <div class="line1">KEMENTERIAN PARIWISATA REPUBLIK INDONESIA</div>
        <div class="line2">POLITEKNIK PARIWISATA LOMBOK</div>
        <div class="line3">
            Jalan Raden Puguh No. 1, Puyung, Jonggat,<br>
            Praya, Lombok Tengah, Provinsi Nusa Tenggara Barat 83561
        </div>
        <div class="line4">
            Telepon (+62-0370) 6158029; Faksimile (+62 0370) 6158030
        </div>
        <div class="line5">
            Laman: <span class="link">www.ppl.ac.id</span> Posel: <span class="link">info@ppl.ac.id</span>
        </div>
    </div>

    <div class="header-right">
        <img src="{{ asset('ppl-icon.png') }}">
    </div>
</div>

<div class="garis"></div>


    <div class="divider"></div>

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
                    @php
                        $priorityClass = strtolower($ticket->priority);
                        $statusClass = strtolower(str_replace(' ', '-', $ticket->status));
                    @endphp
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $ticket->ticket }}</td>
                    <td>{{ $ticket->nama }}</td>
                    <td>{{ $ticket->issuetype }} - {{ $ticket->department }}</td>
                    <td>{{ $ticket->subject }}</td>
                    <td>{{ $ticket->description }}</td>
                    <td class="text-center"><span class="badge priority-{{ $priorityClass }}">{{ $ticket->priority }}</span></td>
                    <td class="text-center"><span class="badge status-{{ $statusClass }}">{{ $ticket->status }}</span></td>
                    <td class="text-center">{{ $ticket->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

   

    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>
