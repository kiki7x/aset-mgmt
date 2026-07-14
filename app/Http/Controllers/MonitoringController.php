<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use App\Services\MonitoringService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class MonitoringController extends Controller
{
    public function index(): View
    {
        $monitors = Monitor::orderBy('name')->get()->map(function ($monitor) {
            $monitor->uptime_24h = $monitor->uptimePercentage(24);
            return $monitor;
        });

        return view('admin.monitoring.index', compact('monitors'));
    }

    public function data(): JsonResponse
    {
        $monitors = Monitor::query();

        return DataTables::of($monitors)
            ->addColumn('type_label', function ($row) {
                $icons = [
                    'website' => '<i class="fa-solid fa-globe mr-1"></i> Website',
                    'server' => '<i class="fa-solid fa-server mr-1"></i> Server',
                ];
                return $icons[$row->type] ?? e($row->type);
            })
            ->addColumn('status_badge', function ($row) {
                if ($row->last_status === 'up') {
                    return '<span class="badge badge-success">UP</span>';
                } elseif ($row->last_status === 'down') {
                    return '<span class="badge badge-danger">DOWN</span>';
                }
                return '<span class="badge badge-secondary">-</span>';
            })
            ->addColumn('interval_label', function ($row) {
                return $row->interval . ' menit';
            })
            ->addColumn('active_badge', function ($row) {
                return $row->is_active
                    ? '<span class="badge badge-success">Aktif</span>'
                    : '<span class="badge badge-secondary">Nonaktif</span>';
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <button class="btn btn-sm btn-outline-primary btn-check-now" data-id="' . $row->id . '" title="Cek Sekarang"><i class="fa-solid fa-bolt"></i></button>
                    <button class="btn btn-sm btn-outline-warning btn-edit" data-id="' . $row->id . '" title="Edit"><i class="fa-solid fa-pen"></i></button>
                    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="' . $row->id . '" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                ';
            })
            ->rawColumns(['type_label', 'status_badge', 'active_badge', 'aksi'])
            ->make(true);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:website,server',
            'url' => 'required|url',
            'interval' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Monitor::create($validated);

        return response()->json(['success' => true, 'message' => 'Monitor berhasil ditambahkan.']);
    }

    public function edit($id): JsonResponse
    {
        $monitor = Monitor::findOrFail($id);
        return response()->json($monitor);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $monitor = Monitor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:website,server',
            'url' => 'required|url',
            'interval' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $monitor->update($validated);

        return response()->json(['success' => true, 'message' => 'Monitor berhasil diperbarui.']);
    }

    public function destroy($id): JsonResponse
    {
        $monitor = Monitor::findOrFail($id);
        $monitor->delete();

        return response()->json(['success' => true, 'message' => 'Monitor berhasil dihapus.']);
    }

    public function checkNow($id, MonitoringService $service): JsonResponse
    {
        $monitor = Monitor::findOrFail($id);
        $heartbeat = $service->check($monitor);

        return response()->json([
            'success' => true,
            'message' => "Cek selesai: {$heartbeat->status} ({$heartbeat->response_time} ms)",
            'status' => $heartbeat->status,
            'response_time' => $heartbeat->response_time,
        ]);
    }

    public function chartData($id, Request $request): JsonResponse
    {
        $monitor = Monitor::findOrFail($id);
        $range = $request->input('range', '24h');

        [$since, $groupFormat, $labelFormat] = match ($range) {
            '7d' => [now()->subDays(7), '%Y-%m-%d', 'd M'],
            '30d' => [now()->subDays(30), '%Y-%m-%d', 'd M'],
            default => [now()->subHours(24), '%Y-%m-%d %H:00:00', 'H:00'],
        };

        $rows = $monitor->heartbeats()
            ->where('checked_at', '>=', $since)
            ->select(
                DB::raw("DATE_FORMAT(checked_at, '{$groupFormat}') as periode"),
                DB::raw("SUM(CASE WHEN status = 'up' THEN 1 ELSE 0 END) as up_count"),
                DB::raw('COUNT(*) as total'),
                DB::raw('AVG(response_time) as avg_response')
            )
            ->groupBy('periode')
            ->orderBy('periode')
            ->get();

        $labels = [];
        $uptimeData = [];
        $responseData = [];

        foreach ($rows as $row) {
            $labels[] = \Carbon\Carbon::parse($row->periode)->format($labelFormat);
            $uptimeData[] = $row->total > 0 ? round(($row->up_count / $row->total) * 100, 2) : 0;
            $responseData[] = round((float) $row->avg_response);
        }

        return response()->json([
            'labels' => $labels,
            'uptime' => $uptimeData,
            'response_time' => $responseData,
        ]);
    }
}
