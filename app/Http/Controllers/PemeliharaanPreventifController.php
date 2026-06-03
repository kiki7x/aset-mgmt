<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class PemeliharaanPreventifController extends Controller
{
    public function index(): View
    {
        return view('admin.pemeliharaan-preventif.index');
    }

    public function getMaintenanceSchedules(Request $request): JsonResponse
    {
        // 1. Ambil data dari tabel Jadwal Pemeliharaan (Maintenances_scheduleModel)
        $events = \App\Models\Maintenances_scheduleModel::where('start', '>=', $request->start)
            ->where('start', '<=', $request->end)
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'title' => $schedule->name,
                    'start' => (string) $schedule->start,
                    'end' => (string) $schedule->end,
                    'description' => $schedule->asset->name,
                    'allDay' => true,
                    'color' => '#007bff', // Warna biru untuk jadwal pemeliharaan
                    //extendedProps tambahan untuk menampilkan tag
                    'tag' => $schedule->asset->tag,
                    'is_event' => true,
                    'frequency' => $schedule->frequency,
                    'period' => $schedule->start, // Tambahkan properti period untuk menyimpan tanggal pemeliharaan
                ];
            });
        // dd($events);

        // 2. Ambil data dari tabel (MaintenancesModel) sebagai riwayat pemeliharaan yang sudah selesai
        $histories = \App\Models\MaintenancesModel::where('period', '>=', $request->start)
            ->where('period', '<=', $request->end)
            ->get()
            ->map(function ($history) {
                return [
                    'id' => 'his-' . $history->id,
                    'title' => $history->name,
                    'start' => (string) $history->period,
                    'end' => (string) $history->period,
                    'description' => $history->maintenance_schedule->asset->name,
                    'allDay' => true,
                    'color' => '#28a745', // Warna hijau untuk riwayat (history)
                    //extendedProps tambahan untuk menampilkan tag
                    'tag' => $history->maintenance_schedule->asset->tag,
                    'id_asset' => $history->maintenance_schedule->asset_id,
                    'attachment_link' => $history->attachment_link,
                    'cost' => $history->cost,
                    'status' => $history->status,
                    'notes' => $history->notes,
                    'classification' =>
                        $history->maintenance_schedule->asset->classification->name == 'TIK' ? 'asettik' :
                        ($history->maintenance_schedule->asset->classification->name == 'Kendaraan' || 'Mesin/Elektronik' ? 'asetrt' : ''),
                ];
            });

        // Gabungkan kedua dataset
        $events = $events->concat($histories);

        return response()->json($events);
        // return response()->json($schedules_backup);
    }

    public function getCategories(Request $request, $id): JsonResponse
    {
        $categories = \App\Models\AssetcategoriesModel::where('classification_id', $id)->get();
        return response()->json($categories);
    }

    public function getAssets(Request $request, $id): JsonResponse
    {
        $assets = \App\Models\AssetsModel::where('category_id', $id)->get();
        return response()->json($assets);
    }

    public function completedDataTable(Request $request): JsonResponse
    {
        $histories = \App\Models\MaintenancesModel::with(['maintenance_schedule.asset', 'pic'])
            ->where('status', 'Selesai')
            ->where('maintenance_schedule_id', '!=', null)
            ->orderBy('period', 'desc')
            ->get()
            ->map(function ($history) {
                return [
                    'id' => $history->id,
                    'classification_name' => $history->maintenance_schedule->asset->classification->name,
                    'maintenance_name' => $history->name,
                    'asset_id' => $history->maintenance_schedule->asset_id ?? '-',
                    'asset_tag' => $history->maintenance_schedule->asset->tag ?? '-',
                    'asset_name' => $history->maintenance_schedule->asset->name ?? '-',
                    'pic_name' => $history->pic->fullname ?? '-',
                    'period' => $history->period ? Carbon::parse($history->period)->format('d M Y') : '-',
                    'cost' => $history->cost !== null ? number_format($history->cost, 0, ',', '.') : '-',
                    'status' => $history->status,
                    'notes' => $history->notes,
                    'attachment_link' => $history->attachment_link,
                ];
            });
        return response()->json($histories);
    }

    public function scheduleStore(Request $request): JsonResponse
    {
        // 1. VALIDASI
        $request->validate([
            'asset' => 'required',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('maintenances_schedule', 'name')->where(function ($query) use ($request) {
                    return $query->where('asset_id', $request->input('asset'));
                }),
            ],
            'end' => 'required',
            'frequency' => 'required',
            'reminder' => 'required',
        ]);

        // 2. PENYIMPANAN DATA KE DATABASE
        try {
            $data = [
                'asset_id' => $request->input('asset'), // Relasi ke asset,
                'name' => $request->input('name'),
                'start' => Carbon::parse($request->input('end'))->format('Y-m-d H:i:s'), // Set waktu ke awal hari $request->input('end'),
                'end' => Carbon::parse($request->input('end'))->format('Y-m-d H:i:s'), // Default end sama dengan start, akan dihitung ulang jika frequency dan start valid $request->input('end'),
                'frequency' => $request->input('frequency'),
                'reminder' => $request->input('reminder'),
                'status' => "Aktif",
            ];
            \App\Models\Maintenances_scheduleModel::create($data);
            return response()->json(['message' => 'Jadwal pemeliharaan berhasil disimpan.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 404);
        }
    }

    public function preventifAdd(Request $request, $id): JsonResponse // $date adalah tanggal yang dikirim dari frontend saat user klik jadwal pemeliharaan
    {
        $maintenance_schedule = \App\Models\Maintenances_scheduleModel::findOrfail($id);
        if (!$maintenance_schedule) {
            return response()->json([
                'message' => 'Jadwal pemeliharaan tidak ditemukan untuk tanggal tersebut.',
            ], 404);
        } else {
            $data = [
                'id' => $maintenance_schedule->id,
                'name' => $maintenance_schedule->name,
                'start' => (string) $maintenance_schedule->start,
                'end' => (string) $maintenance_schedule->end,
                'tag' => $maintenance_schedule->asset->tag,
                'frequency' => $maintenance_schedule->frequency,
                'asset_id' => $maintenance_schedule->asset->id,
                'asset_name' => $maintenance_schedule->asset->name,
            ];
            return response()->json($data);
            ;
        }
        \Log::info("Loading Preventif Add for date: $maintenance_schedule->start, Maintenance Schedule ID: $id");
    }

    public function preventifStore(Request $request, $id): JsonResponse
    {
        Log::info("Loading Preventif Store for Maintenance Schedule ID: $id");
        // tangani cost agar menghilangkan format Rp dan titik koma jika ada
        if ($request->has('cost')) {
            $cost = preg_replace('/[^\d]/', '', $request->input('cost'));
            $request->merge(['cost' => $cost]);
        }

        // 1. VALIDASI
        $request->validate([
            'attachment_link' => 'required|string',
            'name' => 'required|string', // Untuk checkbox
            'period' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'notes' => 'required|string',
        ], [
            // 'attachment_name.required' => 'Nama bukti dukung wajib diisi.',
            'attachment_link.required' => 'Link bukti dukung wajib diisi.',
            'name.required' => 'Wajib mencentang bahwa pemeliharaan selesai.',
            'period.required' => 'Periode wajib diisi.',
            'cost.required' => 'Biaya wajib diisi.',
            'notes.required' => 'Catatan wajib diisi.',
        ]);

        // 2. PENYIMPANAN DATA KE DATABASE
        try {
            $data = [
                'name' => $request->input('name'),
                'maintenance_schedule_id' => $id, // Relasi ke jadwal pemeliharaan
                'pic_id' => auth()->id(), // Siapa yang menyelesaikan
                'status' => 'Selesai',
                'start' => now(), // Waktu penyelesaian
                'end' => now(), // Waktu penyelesaian
                'period' => $request->input('period'),
                'cost' => $request->input('cost'), // Biaya pemeliharaan
                // 'attachment' => $file_path, // Simpan path file
                // 'attachment_name' => $request->input('attachment_name'),
                'attachment_link' => $request->input('attachment_link'),
                'notes' => $request->input('notes'), // Catatan tambahan
            ];
            // Simpan data ke database
            \App\Models\MaintenancesModel::create($data);

            // 3. UPDATE JADWAL PEMELIHARAAN SELANJUTNYA
            $maintenance_schedule = \App\Models\Maintenances_scheduleModel::findOrFail($id);
            $maintenance_schedule->start = $request->input('future_period');
            $maintenance_schedule->end = $request->input('future_period');
            $maintenance_schedule->save();

            // 4. RESPON BERHASIL
            return response()->json([
                'message' => 'Anda telah menyelesaikan pemeliharaan.'
            ]);
        } catch (\Exception $e) {
            // 4. RESPON GAGAL
            return response()->json([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function print(Request $request): View
    {
        $search = trim($request->query('search', ''));

        $pemeliharaanpreventif = \App\Models\MaintenancesModel::with('maintenance_schedule.asset', 'pic')
        // hanya yang berisi nilai maintenance_schedule_id
        ->whereNotNull('maintenance_schedule_id')
        ->get()
        ->map(function ($preventif) {
            return [
                'id' => $preventif->id,
                'period' => $preventif->period ? Carbon::parse($preventif->period)->format('d M Y') : '-',
                'name' => $preventif->name,
                'asset_tag' => optional($preventif->maintenance_schedule->asset)->tag ?? '-',
                'asset_name' => optional($preventif->maintenance_schedule->asset)->name ?? '-',
                'pic_name' => optional($preventif->pic)->fullname ?? '-',
                // 'cost' => $preventif->cost !== null ? number_format($preventif->cost, 0, ',', '.') : '-',
                'cost' => $preventif->cost !== null ? 'Rp ' . number_format($preventif->cost, 0, ',', '.') : '-',
                'status' => $preventif->status,
                'notes' => $preventif->notes,
                'attachment_link' => $preventif->attachment_link,
            ];
        });

        // dd($pemeliharaanpreventif);

        if ($search !== '') {
            $pemeliharaanpreventif
                ->where(function ($query) use ($search) {
                    $query->where('period', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('pic_id', 'like', "%{$search}%")
                        ->orWhere('asset_tag', 'like', "%{$search}%")
                        ->orWhere('asset_name', 'like', "%{$search}%")
                        ->orWhere('cost', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d %b %Y') LIKE ?", ["%{$search}%"]);
                });
        }
        // dd($pemeliharaanpreventif);

        return view('admin.pemeliharaan-preventif.print', [
            'search' => $search,
            // 'preventifs' => $pemeliharaanpreventif->get(),
            'preventifs' => $pemeliharaanpreventif,
        ]);
    }
}
