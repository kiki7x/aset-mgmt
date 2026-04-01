<?php
namespace App\Exports;

use App\Models\AssetsModel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetExport implements FromQuery, WithMapping, WithHeadings
{
    public function query()
    {
        // Load semua relasi agar tidak lambat (Eager Loading)
        return AssetsModel::with(['classification', 'category', 'supplier', 'location']);
    }

    public function headings(): array
    {
        return [
            'Tag', 'Serial', 'Nama Aset', 'Klasifikasi', 'Kategori',
            'Supplier', 'Lokasi', 'Tgl Beli (YYYY-MM-DD)', 'Garansi (Bulan)'
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->tag,
            $asset->serial,
            $asset->name,
            $asset->classification->name ?? '',
            $asset->category->name ?? '',
            $asset->supplier->name ?? '',
            $asset->location->name ?? '',
            $asset->purchase_date,
            $asset->warranty_months,
        ];
    }
}
