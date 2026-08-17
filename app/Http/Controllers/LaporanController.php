<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;
use Shuchkin\SimpleXLSXGen;
use App\Models\AssetsModel;
use App\Models\BuildingsModel;
use App\Models\LicensesModel;
use App\Models\LicensecategoriesModel;
use App\Models\MaintenancesModel;
use App\Models\TicketsModel;
use App\Models\AssetclassificationsModel;
use App\Models\AssetcategoriesModel;
use App\Models\BorrowingsModel;
use App\Models\KbArticlesModel;
use App\Models\KbCategoriesModel;
use App\Models\Monitor;
use App\Models\MonitorHeartbeat;
use App\Models\User;

class LaporanController extends Controller
{
    public function index(): View
    {
        $klasifikasi = AssetclassificationsModel::all();
        $kategoriAset = AssetcategoriesModel::with('classification')->get();
        $kategoriLisensi = LicensecategoriesModel::all();
        $kategoriKb = KbCategoriesModel::all();
        $penulisKb = User::whereIn('id', KbArticlesModel::select('author_id'))->orderBy('fullname')->get();
        $gedung = BuildingsModel::orderBy('name')->get();

        return view('admin.laporan.index', compact('klasifikasi', 'kategoriAset', 'kategoriLisensi', 'kategoriKb', 'penulisKb', 'gedung'));
    }

    private const METHOD_MAP = [
        'aset-tik' => 'AsetTik',
        'aset-rt'  => 'AsetRt',
        'lisensi'  => 'Lisensi',
        'preventif'=> 'Preventif',
        'korektif' => 'Korektif',
        'tiket'    => 'Tiket',
        'peminjaman' => 'Peminjaman',
        'pusat-pengetahuan' => 'Kb',
        'monitoring' => 'Monitoring',
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
                'Gedung', 'PIC', 'Biaya', 'Status', 'Catatan']
        ];

        foreach ($query->get() as $i => $item) {
            $data[] = [
                $i + 1,
                $item->period ? Carbon::parse($item->period)->format('d M Y') : '-',
                $item->name,
                optional(optional($item->maintenance_schedule)->asset)->tag ?? '-',
                optional(optional($item->maintenance_schedule)->asset)->name ?? '-',
                optional(optional(optional($item->maintenance_schedule)->asset)->classification)->name ?? '-',
                optional(optional(optional(optional($item->maintenance_schedule)->asset)->location)->building)->name ?? '-',
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
                'gedung_name' => optional(optional(optional(optional($item->maintenance_schedule)->asset)->location)->building)->name ?? '-',
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
            'filterLabels' => $this->getPreventifFilterLabels($request),
        ]);
    }

    private function buildPreventifQuery(Request $request)
    {
        $query = MaintenancesModel::with('maintenance_schedule.asset.classification', 'maintenance_schedule.asset.location.building', 'pic')
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

        if ($request->filled('gedung')) {
            $query->whereHas('maintenance_schedule.asset.location.building', function ($q) use ($request) {
                $q->where('id', $request->input('gedung'));
            });
        }

        return $query;
    }

    private function getPreventifFilterLabels(Request $request): array
    {
        $labels = [];
        if ($request->filled('tahun')) {
            $labels[] = 'Tahun: ' . $request->input('tahun');
        }
        if ($request->filled('bulan')) {
            $bulanNama = Carbon::create()->month($request->input('bulan'))->locale('id')->monthName;
            $labels[] = 'Bulan: ' . $bulanNama;
        }
        if ($request->filled('klasifikasi')) {
            $names = AssetclassificationsModel::whereIn('id', (array) $request->input('klasifikasi'))->pluck('name')->toArray();
            $labels[] = 'Klasifikasi: ' . implode(', ', $names);
        }
        if ($request->filled('gedung')) {
            $names = BuildingsModel::whereIn('id', (array) $request->input('gedung'))->pluck('name')->toArray();
            $labels[] = 'Gedung: ' . implode(', ', $names);
        }
        return $labels;
    }

    // ─── PEMELIHARAAN KOREKTIF ──────────────────────────────

    private function exportKorektifExcel(Request $request)
    {
        $query = $this->buildKorektifQuery($request);

        $data = [
            ['No', 'Nama', 'Tag Aset', 'Nama Aset', 'Gedung', 'PIC', 'Prioritas', 'Status',
                'Tanggal Jatuh Tempo', 'Biaya', 'Catatan']
        ];

        foreach ($query->get() as $i => $item) {
            $data[] = [
                $i + 1,
                $item->name,
                optional($item->asset)->tag ?? '-',
                optional($item->asset)->name ?? '-',
                optional(optional(optional($item->asset)->location)->building)->name ?? '-',
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
        $query = MaintenancesModel::with('asset', 'asset.location.building', 'pic')
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

        if ($request->filled('gedung')) {
            $query->whereHas('asset.location.building', function ($q) use ($request) {
                $q->where('id', $request->input('gedung'));
            });
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
        if ($request->filled('gedung')) {
            $names = BuildingsModel::whereIn('id', (array) $request->input('gedung'))->pluck('name')->toArray();
            $labels[] = 'Gedung: ' . implode(', ', $names);
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

    // ─── PEMINJAMAN ────────────────────────────────────────

    private function exportPeminjamanExcel(Request $request)
    {
        $query = $this->buildPeminjamanQuery($request);

        $data = [
            ['No', 'Jenis', 'Barang/Ruangan', 'Peminjam', 'NIP', 'Unit',
                'Tgl Mulai', 'Tgl Akhir', 'Tgl Kembali', 'Tujuan', 'Status']
        ];

        foreach ($query->get() as $i => $item) {
            $itemName = '-';
            if ($item->type === 'ruangan' && $item->location) {
                $itemName = $item->location->name . ' (' . optional($item->location->building)->name . ' Lt ' . $item->location->floor . ')';
            } elseif ($item->type === 'barang') {
                if ($item->items->isNotEmpty()) {
                    $lines = [];
                    foreach ($item->items as $lineItem) {
                        if ($lineItem->asset) {
                            $lines[] = $lineItem->asset->name . ' (' . $lineItem->asset->tag . ')';
                        } elseif ($lineItem->item_name) {
                            $lines[] = $lineItem->item_name . ' (Non Aset)';
                        }
                    }
                    $itemName = implode(PHP_EOL, $lines);
                } elseif ($item->asset) {
                    $itemName = $item->asset->name . ' (' . $item->asset->tag . ')';
                }
            }

            $data[] = [
                $i + 1,
                ucfirst($item->type),
                $itemName,
                $item->borrower_name,
                $item->borrower_nip ?? '-',
                $item->borrower_unit ?? '-',
                Carbon::parse($item->borrow_start)->format('d-m-Y H:i'),
                Carbon::parse($item->borrow_end)->format('d-m-Y H:i'),
                $item->return_date ? Carbon::parse($item->return_date)->format('d-m-Y H:i') : '-',
                $item->purpose,
                $item->status === 'dipinjam' ? 'Dipinjam' : 'Dikembalikan',
            ];
        }

        return SimpleXLSXGen::fromArray($data)
            ->downloadAs(Carbon::now()->format('d-m-Y') . '_sapa-ppl-peminjaman.xlsx');
    }

    private function exportPeminjamanPdf(Request $request)
    {
        $query = $this->buildPeminjamanQuery($request);
        $borrowings = $query->get();
        $filterLabels = $this->getPeminjamanFilterLabels($request);

        return view('admin.laporan.print-peminjaman', [
            'borrowings' => $borrowings,
            'filterLabels' => $filterLabels,
        ]);
    }

    private function buildPeminjamanQuery(Request $request)
    {
        $query = BorrowingsModel::with('location.building', 'asset', 'items.asset');

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('tahun')) {
            $query->whereYear('borrow_start', $request->input('tahun'));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('borrow_start', $request->input('bulan'));
        }

        return $query->latest();
    }

    private function getPeminjamanFilterLabels(Request $request): array
    {
        $labels = [];
        if ($request->filled('type')) {
            $labels[] = 'Jenis: ' . ucfirst($request->input('type'));
        }
        if ($request->filled('status')) {
            $labels[] = 'Status: ' . ucfirst($request->input('status'));
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

    // ─── PUSAT PENGETAHUAN ─────────────────────────────────

    private function exportKbExcel(Request $request)
    {
        $query = $this->buildKbQuery($request);

        $data = [
            ['No', 'Judul', 'Kategori', 'Penulis', 'Status', 'Views', 'Tanggal Dibuat', 'Isi']
        ];

        foreach ($query->get() as $i => $article) {
            $data[] = [
                $i + 1,
                $article->title,
                optional($article->category)->name ?? '-',
                optional($article->author)->fullname ?? '-',
                $article->is_published ? 'Terbit' : 'Draf',
                $article->views ?? 0,
                $article->created_at ? Carbon::parse($article->created_at)->format('d M Y') : '-',
                $this->descriptionToText($article->content),
            ];
        }

        return SimpleXLSXGen::fromArray($data)
            ->downloadAs(Carbon::now()->format('d-m-Y') . '_sapa-ppl-pusat-pengetahuan.xlsx');
    }

    private function exportKbPdf(Request $request)
    {
        $query = $this->buildKbQuery($request);
        $articles = $query->get();
        $filterLabels = $this->getKbFilterLabels($request);

        return view('admin.laporan.print-kb', [
            'articles' => $articles,
            'filterLabels' => $filterLabels,
            'descriptionToText' => function ($html) {
                return $this->descriptionToText($html);
            },
        ]);
    }

    private function buildKbQuery(Request $request)
    {
        $query = KbArticlesModel::with('category', 'author');

        if ($request->filled('kategori')) {
            $query->whereIn('category_id', (array) $request->input('kategori'));
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->input('status'));
        }

        if ($request->filled('penulis')) {
            $query->whereIn('author_id', (array) $request->input('penulis'));
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->input('tahun'));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->input('bulan'));
        }

        return $query->latest();
    }

    private function getKbFilterLabels(Request $request): array
    {
        $labels = [];
        if ($request->filled('kategori')) {
            $names = KbCategoriesModel::whereIn('id', (array) $request->input('kategori'))->pluck('name')->toArray();
            $labels[] = 'Kategori: ' . implode(', ', $names);
        }
        if ($request->filled('status')) {
            $labels[] = 'Status: ' . ($request->input('status') == 1 ? 'Terbit' : 'Draf');
        }
        if ($request->filled('penulis')) {
            $names = User::whereIn('id', (array) $request->input('penulis'))->pluck('fullname')->toArray();
            $labels[] = 'Penulis: ' . implode(', ', $names);
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

    // ─── MONITORING ─────────────────────────────────────────

    private function getMonitoringRange(Request $request): array
    {
        $dari = $request->filled('dari') ? Carbon::parse($request->input('dari'))->startOfDay() : null;
        $sampai = $request->filled('sampai') ? Carbon::parse($request->input('sampai'))->endOfDay() : null;

        return [$dari, $sampai];
    }

    private function buildMonitorFilter(Request $request)
    {
        $query = Monitor::query();

        if ($request->filled('jenis')) {
            $query->where('type', $request->input('jenis'));
        }

        if ($request->filled('status_monitor')) {
            $query->where('is_active', $request->input('status_monitor'));
        }

        return $query;
    }

    private function getMonitoringRekap(Request $request): array
    {
        [$dari, $sampai] = $this->getMonitoringRange($request);

        $monitors = $this->buildMonitorFilter($request)->orderBy('name')->get();
        $rows = [];

        foreach ($monitors as $monitor) {
            $hb = $monitor->heartbeats();
            if ($dari) $hb->where('checked_at', '>=', $dari);
            if ($sampai) $hb->where('checked_at', '<=', $sampai);

            $total = (clone $hb)->count();
            $up = (clone $hb)->where('status', 'up')->count();
            $down = $total - $up;

            $stats = (clone $hb)->select(
                DB::raw('AVG(response_time) as avg_resp'),
                DB::raw('MIN(response_time) as min_resp'),
                DB::raw('MAX(response_time) as max_resp')
            )->first();

            $rows[] = [
                'name' => $monitor->name,
                'type' => $monitor->type === 'server' ? 'Server' : 'Website',
                'url' => $monitor->url,
                'last_status' => $monitor->last_status ?? '-',
                'is_active' => $monitor->is_active ? 'Aktif' : 'Nonaktif',
                'total' => $total,
                'up' => $up,
                'down' => $down,
                'uptime' => $total > 0 ? round(($up / $total) * 100, 2) : 0,
                'avg_response' => $stats->avg_resp !== null ? (int) round($stats->avg_resp) : null,
                'min_response' => $stats->min_resp !== null ? (int) $stats->min_resp : null,
                'max_response' => $stats->max_resp !== null ? (int) $stats->max_resp : null,
            ];
        }

        return $rows;
    }

    private function getMonitoringDetail(Request $request)
    {
        [$dari, $sampai] = $this->getMonitoringRange($request);

        $query = MonitorHeartbeat::with('monitor');

        if ($request->filled('jenis')) {
            $query->whereHas('monitor', function ($q) use ($request) {
                $q->where('type', $request->input('jenis'));
            });
        }

        if ($request->filled('status_monitor')) {
            $query->whereHas('monitor', function ($q) use ($request) {
                $q->where('is_active', $request->input('status_monitor'));
            });
        }

        if ($dari) $query->where('checked_at', '>=', $dari);
        if ($sampai) $query->where('checked_at', '<=', $sampai);

        return $query->orderByDesc('checked_at')->get();
    }

    private function exportMonitoringExcel(Request $request)
    {
        $rekap = $this->getMonitoringRekap($request);
        $detail = $this->getMonitoringDetail($request);

        $rekapData = [
            ['No', 'Nama Monitor', 'Jenis', 'URL', 'Status Terakhir', 'Total Cek', 'Up', 'Down', 'Uptime %', 'Avg Response (ms)', 'Min Response (ms)', 'Max Response (ms)']
        ];

        foreach ($rekap as $i => $row) {
            $rekapData[] = [
                $i + 1,
                $row['name'],
                $row['type'],
                $row['url'],
                $row['last_status'] === '-' ? '-' : strtoupper($row['last_status']),
                $row['total'],
                $row['up'],
                $row['down'],
                $row['uptime'],
                $row['avg_response'] ?? '-',
                $row['min_response'] ?? '-',
                $row['max_response'] ?? '-',
            ];
        }

        $detailData = [
            ['No', 'Monitor', 'Jenis', 'Waktu Cek', 'Status', 'Response (ms)', 'Status Code', 'Error']
        ];

        foreach ($detail as $i => $hb) {
            $detailData[] = [
                $i + 1,
                optional($hb->monitor)->name ?? '-',
                optional($hb->monitor)->type === 'server' ? 'Server' : 'Website',
                $hb->checked_at ? Carbon::parse($hb->checked_at)->format('d M Y H:i:s') : '-',
                strtoupper($hb->status),
                $hb->response_time ?? '-',
                $hb->status_code ?? '-',
                $hb->error ?? '-',
            ];
        }

        $xlsx = new SimpleXLSXGen();
        $xlsx->addSheet($rekapData, 'Rekap');
        $xlsx->addSheet($detailData, 'Detail');

        return $xlsx->downloadAs(Carbon::now()->format('d-m-Y') . '_sapa-ppl-monitoring.xlsx');
    }

    private function exportMonitoringPdf(Request $request)
    {
        $rekap = $this->getMonitoringRekap($request);
        $filterLabels = $this->getMonitoringFilterLabels($request);

        return view('admin.laporan.print-monitoring', [
            'rekap' => $rekap,
            'filterLabels' => $filterLabels,
        ]);
    }

    private function getMonitoringFilterLabels(Request $request): array
    {
        $labels = [];
        if ($request->filled('dari') || $request->filled('sampai')) {
            $labels[] = 'Periode: ' . ($request->input('dari') ?? '-') . ' s/d ' . ($request->input('sampai') ?? '-');
        }
        if ($request->filled('jenis')) {
            $labels[] = 'Jenis: ' . ($request->input('jenis') === 'server' ? 'Server' : 'Website');
        }
        if ($request->filled('status_monitor')) {
            $labels[] = 'Status Monitor: ' . ($request->input('status_monitor') == 1 ? 'Aktif' : 'Nonaktif');
        }
        return $labels;
    }
}
