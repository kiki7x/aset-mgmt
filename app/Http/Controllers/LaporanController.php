<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Shuchkin\SimpleXLSXGen;
use App\Models\AssetsModel;
use App\Models\LicensesModel;
use App\Models\LicensecategoriesModel;
use App\Models\MaintenancesModel;
use App\Models\TicketsModel;
use App\Models\AssetclassificationsModel;
use App\Models\AssetcategoriesModel;

class LaporanController extends Controller
{
    public function index(): View
    {
        $klasifikasi = AssetclassificationsModel::all();
        $kategoriAset = AssetcategoriesModel::with('classification')->get();
        $kategoriLisensi = LicensecategoriesModel::all();

        return view('admin.laporan.index', compact('klasifikasi', 'kategoriAset', 'kategoriLisensi'));
    }

    private const METHOD_MAP = [
        'aset-tik' => 'AsetTik',
        'aset-rt'  => 'AsetRt',
        'lisensi'  => 'Lisensi',
        'preventif'=> 'Preventif',
        'korektif' => 'Korektif',
        'tiket'    => 'Tiket',
    ];

    public function exportExcel(Request $request)
    {
        $type = $request->input('type');
        $suffix = self::METHOD_MAP[$type] ?? null;
        if (!$suffix) abort(404);
        $method = 'export' . $suffix . 'Excel';
        return $this->$method($request);
    }

    public function exportPdf(Request $request)
    {
        $type = $request->input('type');
        $suffix = self::METHOD_MAP[$type] ?? null;
        if (!$suffix) abort(404);
        $method = 'export' . $suffix . 'Pdf';
        return $this->$method($request);
    }

    // ─── ASET TIK ───────────────────────────────────────────

    private function exportAsetTikExcel(Request $request)
    {
        $query = $this->buildAsetQuery($request, 2);

        $data = [
            ['No', 'Tag', 'Klasifikasi', 'Nama', 'Kategori', 'Pengelola', 'Pengguna',
                'Merk/Pabrikan', 'Model', 'Supplier', 'Serial', 'Status', 'Lokasi',
                'Tanggal Perolehan', 'Garansi (Bulan)', 'Notes']
        ];

        foreach ($query->get() as $i => $asset) {
            $data[] = [
                $i + 1,
                $asset->tag,
                optional($asset->classification)->name ?? '-',
                $asset->name,
                optional($asset->category)->name ?? '-',
                optional($asset->admin)->fullname ?? '-',
                optional($asset->user)->fullname ?? '-',
                optional($asset->manufacturer)->name ?? '-',
                optional($asset->model)->name ?? '-',
                optional($asset->supplier)->name ?? '-',
                $asset->serial ?? '-',
                optional($asset->status)->name ?? '-',
                optional($asset->location)->name ?? '-',
                $asset->purchase_date ? Carbon::parse($asset->purchase_date)->format('d-m-Y') : '-',
                $asset->warranty_months ?? '-',
                $asset->notes ?? '-',
            ];
        }

        return SimpleXLSXGen::fromArray($data)
            ->downloadAs(Carbon::now()->format('d-m-Y') . '_sapa-ppl-aset-tik.xlsx');
    }

    private function exportAsetTikPdf(Request $request)
    {
        $query = $this->buildAsetQuery($request, 2);
        $assets = $query->get();
        $filterLabels = $this->getAsetFilterLabels($request);

        return view('admin.laporan.print-aset', [
            'assets' => $assets,
            'title' => 'Daftar Aset TIK',
            'filterLabels' => $filterLabels,
            'tahun' => $request->input('tahun'),
            'bulan' => $request->input('bulan'),
        ]);
    }

    // ─── ASET RT ────────────────────────────────────────────

    private function exportAsetRtExcel(Request $request)
    {
        $query = $this->buildAsetQuery($request, [3, 4]);

        $data = [
            ['No', 'Tag', 'Klasifikasi', 'Nama', 'Kategori', 'Pengelola', 'Pengguna',
                'Merk/Pabrikan', 'Model', 'Supplier', 'Serial', 'Status', 'Lokasi',
                'Tanggal Perolehan', 'Garansi (Bulan)', 'Notes']
        ];

        foreach ($query->get() as $i => $asset) {
            $data[] = [
                $i + 1,
                $asset->tag,
                optional($asset->classification)->name ?? '-',
                $asset->name,
                optional($asset->category)->name ?? '-',
                optional($asset->admin)->fullname ?? '-',
                optional($asset->user)->fullname ?? '-',
                optional($asset->manufacturer)->name ?? '-',
                optional($asset->model)->name ?? '-',
                optional($asset->supplier)->name ?? '-',
                $asset->serial ?? '-',
                optional($asset->status)->name ?? '-',
                optional($asset->location)->name ?? '-',
                $asset->purchase_date ? Carbon::parse($asset->purchase_date)->format('d-m-Y') : '-',
                $asset->warranty_months ?? '-',
                $asset->notes ?? '-',
            ];
        }

        return SimpleXLSXGen::fromArray($data)
            ->downloadAs(Carbon::now()->format('d-m-Y') . '_sapa-ppl-aset-rt.xlsx');
    }

    private function exportAsetRtPdf(Request $request)
    {
        $query = $this->buildAsetQuery($request, [3, 4]);
        $assets = $query->get();
        $filterLabels = $this->getAsetFilterLabels($request);

        return view('admin.laporan.print-aset', [
            'assets' => $assets,
            'title' => 'Daftar Aset Rumah Tangga',
            'filterLabels' => $filterLabels,
            'tahun' => $request->input('tahun'),
            'bulan' => $request->input('bulan'),
        ]);
    }

    private function buildAsetQuery(Request $request, $classificationIds)
    {
        $query = AssetsModel::with([
            'classification', 'category', 'admin', 'user',
            'manufacturer', 'model', 'supplier', 'status', 'location'
        ])->whereIn('classification_id', (array) $classificationIds);

        if ($request->filled('klasifikasi')) {
            $query->whereIn('classification_id', (array) $request->input('klasifikasi'));
        }

        if ($request->filled('kategori')) {
            $query->whereIn('category_id', (array) $request->input('kategori'));
        }

        if ($request->filled('tahun')) {
            $query->whereYear('purchase_date', $request->input('tahun'));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('purchase_date', $request->input('bulan'));
        }

        return $query;
    }

    private function getAsetFilterLabels(Request $request): array
    {
        $labels = [];
        if ($request->filled('klasifikasi')) {
            $names = AssetclassificationsModel::whereIn('id', (array) $request->input('klasifikasi'))->pluck('name')->toArray();
            $labels[] = 'Klasifikasi: ' . implode(', ', $names);
        }
        if ($request->filled('kategori')) {
            $names = AssetcategoriesModel::whereIn('id', (array) $request->input('kategori'))->pluck('name')->toArray();
            $labels[] = 'Kategori: ' . implode(', ', $names);
        }
        if ($request->filled('tahun')) {
            $labels[] = 'Tahun: ' . $request->input('tahun');
        }
        if ($request->filled('bulan')) {
            $bulanNama = Carbon::create()->month($request->input('bulan'))->locale('id')->monthName;
            $labels[] = 'Bulan: ' . $bulanNama;
        }
        return $labels;
    }

    // ─── LISENSI ────────────────────────────────────────────

    private function exportLisensiExcel(Request $request)
    {
        $query = LicensesModel::with(['status', 'category', 'supplier']);

        if ($request->filled('kategori')) {
            $query->whereIn('category_id', (array) $request->input('kategori'));
        }

        $data = [
            ['No', 'Tag', 'Kategori', 'Nama', 'Supplier', 'Serial', 'Seats', 'Status']
        ];

        foreach ($query->get() as $i => $license) {
            $data[] = [
                $i + 1,
                $license->tag,
                optional($license->category)->name ?? '-',
                $license->name,
                optional($license->supplier)->name ?? '-',
                $license->serial ?? '-',
                $license->seats ?? '-',
                optional($license->status)->name ?? '-',
            ];
        }

        return SimpleXLSXGen::fromArray($data)
            ->downloadAs(Carbon::now()->format('d-m-Y') . '_sapa-ppl-lisensi.xlsx');
    }

    private function exportLisensiPdf(Request $request)
    {
        $query = LicensesModel::with(['status', 'category', 'supplier']);

        if ($request->filled('kategori')) {
            $query->whereIn('category_id', (array) $request->input('kategori'));
        }

        $licenses = $query->get();
        $filterLabels = [];
        if ($request->filled('kategori')) {
            $names = LicensecategoriesModel::whereIn('id', (array) $request->input('kategori'))->pluck('name')->toArray();
            $filterLabels[] = 'Kategori: ' . implode(', ', $names);
        }

        return view('admin.laporan.print-lisensi', [
            'licenses' => $licenses,
            'filterLabels' => $filterLabels,
        ]);
    }

    // ─── PEMELIHARAAN PREVENTIF ─────────────────────────────

    private function exportPreventifExcel(Request $request)
    {
        $query = $this->buildPreventifQuery($request);

        $data = [
            ['No', 'Periode', 'Nama Pemeliharaan', 'Tag Aset', 'Nama Aset', 'Klasifikasi',
                'PIC', 'Biaya', 'Status', 'Catatan']
        ];

        foreach ($query->get() as $i => $item) {
            $data[] = [
                $i + 1,
                $item->period ? Carbon::parse($item->period)->format('d M Y') : '-',
                $item->name,
                optional(optional($item->maintenance_schedule)->asset)->tag ?? '-',
                optional(optional($item->maintenance_schedule)->asset)->name ?? '-',
                optional(optional(optional($item->maintenance_schedule)->asset)->classification)->name ?? '-',
                optional($item->pic)->fullname ?? '-',
                $item->cost !== null ? 'Rp ' . number_format($item->cost, 0, ',', '.') : '-',
                $item->status,
                $item->notes ?? '-',
            ];
        }

        return SimpleXLSXGen::fromArray($data)
            ->downloadAs(Carbon::now()->format('d-m-Y') . '_sapa-ppl-preventif.xlsx');
    }

    private function exportPreventifPdf(Request $request)
    {
        $query = $this->buildPreventifQuery($request);
        $preventifs = $query->get()->map(function ($item) {
            return [
                'period' => $item->period ? Carbon::parse($item->period)->format('d M Y') : '-',
                'name' => $item->name,
                'asset_tag' => optional(optional($item->maintenance_schedule)->asset)->tag ?? '-',
                'asset_name' => optional(optional($item->maintenance_schedule)->asset)->name ?? '-',
                'classification_name' => optional(optional(optional($item->maintenance_schedule)->asset)->classification)->name ?? '-',
                'pic_name' => optional($item->pic)->fullname ?? '-',
                'cost' => $item->cost !== null ? 'Rp ' . number_format($item->cost, 0, ',', '.') : '-',
                'status' => $item->status,
                'notes' => $item->notes ?? '-',
                'attachment_link' => $item->attachment_link,
            ];
        });

        $totalCost = $query->get()->sum('cost');

        return view('admin.pemeliharaan-preventif.print', [
            'preventifs' => $preventifs,
            'totalCost' => $totalCost ? 'Rp ' . number_format($totalCost, 0, ',', '.') : 0,
        ]);
    }

    private function buildPreventifQuery(Request $request)
    {
        $query = MaintenancesModel::with('maintenance_schedule.asset.classification', 'pic')
            ->whereNotNull('maintenance_schedule_id');

        if ($request->filled('tahun')) {
            $query->whereYear('period', $request->input('tahun'));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('period', $request->input('bulan'));
        }

        if ($request->filled('klasifikasi')) {
            $query->whereHas('maintenance_schedule.asset.classification', function ($q) use ($request) {
                $q->whereIn('id', (array) $request->input('klasifikasi'));
            });
        }

        return $query;
    }

    // ─── PEMELIHARAAN KOREKTIF ──────────────────────────────

    private function exportKorektifExcel(Request $request)
    {
        $query = $this->buildKorektifQuery($request);

        $data = [
            ['No', 'Nama', 'Tag Aset', 'Nama Aset', 'PIC', 'Prioritas', 'Status',
                'Tanggal Jatuh Tempo', 'Biaya', 'Catatan']
        ];

        foreach ($query->get() as $i => $item) {
            $data[] = [
                $i + 1,
                $item->name,
                optional($item->asset)->tag ?? '-',
                optional($item->asset)->name ?? '-',
                optional($item->pic)->fullname ?? '-',
                $item->priority ?? '-',
                $item->status,
                $item->duedate ? Carbon::parse($item->duedate)->format('d M Y') : '-',
                $item->cost !== null ? 'Rp ' . number_format($item->cost, 0, ',', '.') : '-',
                $item->notes ?? '-',
            ];
        }

        return SimpleXLSXGen::fromArray($data)
            ->downloadAs(Carbon::now()->format('d-m-Y') . '_sapa-ppl-korektif.xlsx');
    }

    private function exportKorektifPdf(Request $request)
    {
        $query = $this->buildKorektifQuery($request);
        $korektifs = $query->get();

        return view('admin.laporan.print-korektif', [
            'korektifs' => $korektifs,
            'filterLabels' => $this->getKorektifFilterLabels($request),
        ]);
    }

    private function buildKorektifQuery(Request $request)
    {
        $query = MaintenancesModel::with('asset', 'pic')
            ->whereDoesntHave('maintenance_schedule');

        if ($request->filled('tahun')) {
            $query->whereYear('duedate', $request->input('tahun'));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('duedate', $request->input('bulan'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        return $query;
    }

    private function getKorektifFilterLabels(Request $request): array
    {
        $labels = [];
        if ($request->filled('tahun')) {
            $labels[] = 'Tahun: ' . $request->input('tahun');
        }
        if ($request->filled('bulan')) {
            $bulanNama = Carbon::create()->month($request->input('bulan'))->locale('id')->monthName;
            $labels[] = 'Bulan: ' . $bulanNama;
        }
        if ($request->filled('status')) {
            $labels[] = 'Status: ' . $request->input('status');
        }
        return $labels;
    }

    // ─── TIKET ──────────────────────────────────────────────

    private function exportTiketExcel(Request $request)
    {
        $query = $this->buildTiketQuery($request);

        $data = [
            ['No', 'Tiket', 'Nama', 'Email', 'WhatsApp', 'Subjek', 'Jenis', 'Bidang',
                'Prioritas', 'Status', 'Deskripsi', 'Tanggal']
        ];

        foreach ($query->get() as $i => $ticket) {
            $data[] = [
                $i + 1,
                $ticket->ticket,
                $ticket->nama,
                $ticket->email,
                $ticket->whatsapp_number ?? '-',
                $ticket->subject,
                $ticket->issuetype,
                $ticket->department,
                $ticket->priority,
                $ticket->status,
                $this->descriptionToText($ticket->description),
                $ticket->created_at->format('d M Y H:i'),
            ];
        }

        return SimpleXLSXGen::fromArray($data)
            ->downloadAs(Carbon::now()->format('d-m-Y') . '_sapa-ppl-tiket.xlsx');
    }

    private function exportTiketPdf(Request $request)
    {
        $query = $this->buildTiketQuery($request);

        return view('admin.tiket.print', [
            'tickets' => $query->get(),
            'search' => $request->input('search', ''),
            'issuetype' => $request->input('jenis_tiket', ''),
            'department' => $request->input('departemen', ''),
            'descriptionToText' => function ($html) {
                return $this->descriptionToText($html);
            },
        ]);
    }

    /**
     * Konversi HTML description (dari Summernote) ke teks terbaca.
     * Berguna untuk export Excel dan cetak PDF agar list tetap rapi.
     */
    private function descriptionToText($html): string
    {
        if (!$html) return '';

        // Konversi <ol><li>...</li></ol> → 1. ...\n2. ...
        $html = preg_replace_callback('/<ol[^>]*>(.*?)<\/ol>/si', function ($m) {
            $items = [];
            preg_match_all('/<li[^>]*>(.*?)<\/li>/si', $m[1], $matches);
            foreach ($matches[1] as $i => $item) {
                $items[] = ($i + 1) . '. ' . trim(strip_tags($item));
            }
            return "\n" . implode("\n", $items) . "\n";
        }, $html);

        // Konversi <ul><li>...</li></ul> → • ...\n• ...
        $html = preg_replace_callback('/<ul[^>]*>(.*?)<\/ul>/si', function ($m) {
            $items = [];
            preg_match_all('/<li[^>]*>(.*?)<\/li>/si', $m[1], $matches);
            foreach ($matches[1] as $item) {
                $items[] = '• ' . trim(strip_tags($item));
            }
            return "\n" . implode("\n", $items) . "\n";
        }, $html);

        // <br> → newline
        $html = preg_replace('/<br\s*\/?>/i', "\n", $html);
        // </p> → double newline
        $html = preg_replace('/<\/p>/i', "\n\n", $html);
        // <p> → nothing (opening tag)
        $html = preg_replace('/<p[^>]*>/i', '', $html);

        return trim(strip_tags($html));
    }

    private function buildTiketQuery(Request $request)
    {
        $query = TicketsModel::latest();

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->input('tahun'));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->input('bulan'));
        }

        if ($request->filled('jenis_tiket')) {
            $query->where('issuetype', $request->input('jenis_tiket'));
        }

        if ($request->filled('departemen')) {
            $query->where('department', $request->input('departemen'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        return $query;
    }
}
