<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Carbon;


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
                    'description' => "Pemeliharaan untuk aset: " . $schedule->asset->tag . ' - ' . $schedule->asset->name,
                    'allDay' => true,
                    'color' => '#007bff', // Warna biru untuk jadwal pemeliharaan
                    //extendedProps tambahan untuk menampilkan tag
                    'tag' => $schedule->asset->tag,
                    'is_event' => true,
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
                    'attachment_link' => $history->attachment_link,
                    'cost' => $history->cost,
                    'status' => $history->status,
                    'notes' => $history->notes,
                ];
            });

        // Gabungkan kedua dataset
        $events = $events->concat($histories);
        return response()->json($events);
        // return response()->json($schedules_backup);
    }

    public function preventifAdd(Request $request, $id): JsonResponse
    {
        $maintenance_schedule = \App\Models\Maintenances_scheduleModel::findOrFail($id);
        $asset = \App\Models\AssetsModel::findOrFail($maintenance_schedule->asset_id);
        Log::info("Loading Add Preventif for Maintenance Schedule Name: $maintenance_schedule->name (ID: $id)");
        return response()->json(['maintenance_schedule' => $maintenance_schedule, 'asset' => $asset]);
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
            // 'attachment' adalah nama input file di HTML: <input type="file" name="attachment">
            // 'attachment_name' => 'required|string',
            'attachment_link' => 'required|string',
            'name' => 'required|string', // Untuk checkbox
            // 'start' => 'required|date',
            // 'end' => 'required|date|after:start',
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
}
