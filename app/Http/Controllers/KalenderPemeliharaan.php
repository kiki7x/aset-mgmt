<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
// use Illuminate\Support\Carbon;


class KalenderPemeliharaan extends Controller
{
    public function index(): View
    {
        return view('admin.kalender-pemeliharaan.index');
    }

    public function getMaintenanceSchedules(Request $request): JsonResponse
    {
        // Logika untuk mengambil data jadwal pemeliharaan dari database
        // Anda bisa menggunakan model Eloquent untuk mengambil data dari tabel yang sesuai
        // Contoh:
        // $schedules = \App\Models\Maintenances_scheduleModel::all();

        // Untuk contoh ini, kita akan mengembalikan data dummy
        $schedules_backup = [
            [
                'id' => 1,
                'title' => 'Pemeliharaan AC',
                'start' => '2026-04-01',
                'end' => '2026-04-01',
                'description' => 'Pemeliharaan rutin AC di ruang server.',
            ],
            [
                'id' => 2,
                'title' => 'Pengecekan Generator',
                'start' => '2026-04-05',
                'end' => '2026-04-05',
                'description' => 'Pengecekan rutin generator untuk memastikan kesiapan saat darurat.',
            ],
            // Tambahkan data jadwal lainnya sesuai kebutuhan

        ];

        $events = \App\Models\Maintenances_scheduleModel::whereDate('created_at', '>=', $request->start)
            ->whereDate('updated_at', '<=', $request->end)
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'title' => $schedule->name,
                    // 'start' => (string) $schedule->created_at,
                    // 'end' => (string) $schedule->updated_at,
                    'start' => $schedule->created_at,
                    'end' => $schedule->updated_at,
                    'allDay' => true,
                    // 'description' => "Pemeliharaan untuk aset: " . $schedule->asset->name,
                ];
            });
        // dd($events);
        return response()->json($events);
        // return response()->json($schedules_backup);
    }
}
