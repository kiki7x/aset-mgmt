<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman Aset</title>
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

    <div class="report-title"><h2>Daftar Peminjaman Aset</h2></div>

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
                <th>Jenis</th>
                <th>Barang/Ruangan</th>
                <th>Peminjam</th>
                <th>NIP</th>
                <th>Unit</th>
                <th>Tgl Mulai</th>
                <th>Tgl Akhir</th>
                <th>Tgl Kembali</th>
                <th>Tujuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($borrowings as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ ucfirst($item->type) }}</td>
                    <td>
                        @if ($item->type === 'ruangan' && $item->location)
                            {{ $item->location->name }}<br>
                            <small>({{ $item->location->building?->name ?? '' }} Lt {{ $item->location->floor }})</small>
                        @elseif ($item->type === 'barang')
                            @if ($item->items->isNotEmpty())
                                @foreach ($item->items as $lineItem)
                                    @if ($lineItem->asset)
                                        {{ $loop->iteration }}. {{ $lineItem->asset->name }}<br>
                                        <small>({{ $lineItem->asset->tag }})</small><br>
                                    @elseif ($lineItem->item_name)
                                        {{ $loop->iteration }}. {{ $lineItem->item_name }}<br>
                                    @endif
                                @endforeach
                            @elseif ($item->asset)
                                {{ $item->asset->name }}<br>
                                <small>({{ $item->asset->tag }})</small>
                            @else
                                -
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item->borrower_name }}</td>
                    <td>{{ $item->borrower_nip ?? '-' }}</td>
                    <td>{{ $item->borrower_unit ?? '-' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->borrow_start)->format('d/m/Y H:i') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->borrow_end)->format('d/m/Y H:i') }}</td>
                    <td class="text-center">{{ $item->return_date ? \Carbon\Carbon::parse($item->return_date)->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $item->purpose }}</td>
                    <td class="text-center">{{ $item->status === 'dipinjam' ? 'Dipinjam' : 'Dikembalikan' }}</td>
                </tr>
            @empty
                <tr><td colspan="11" class="text-center">Data tidak ditemukan.</td></tr>
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
