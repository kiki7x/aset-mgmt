<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class LogsController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('username')->get();
        return view('admin.logs.index', compact('users'));
    }

    public function data(): JsonResponse
    {
        $logs = ActivityLog::with('user')->latest();

        return DataTables::of($logs)
            ->addColumn('waktu', function ($row) {
                return $row->created_at->format('d M Y H:i:s');
            })
            ->addColumn('user_name', function ($row) {
                return $row->user?->name ?? '<span class="text-muted">System</span>';
            })
            ->addColumn('module', function ($row) {
                $label = class_basename($row->loggable_type);
                $icons = [
                    'AssetsModel' => 'fa-computer',
                    'TicketsModel' => 'fa-ticket',
                    'MaintenancesModel' => 'fa-screwdriver-wrench',
                ];
                $icon = $icons[$label] ?? 'fa-circle';
                $moduleLabels = [
                    'AssetsModel' => 'Aset',
                    'TicketsModel' => 'Tiket',
                    'MaintenancesModel' => 'Pemeliharaan',
                ];
                $moduleLabel = $moduleLabels[$label] ?? $label;
                return '<i class="fa-solid ' . $icon . ' mr-1"></i> ' . $moduleLabel;
            })
            ->addColumn('event_badge', function ($row) {
                $colors = [
                    'created' => 'success',
                    'updated' => 'primary',
                    'deleted' => 'danger',
                ];
                $color = $colors[$row->event] ?? 'secondary';
                return '<span class="badge badge-' . $color . '">' . ucfirst($row->event) . '</span>';
            })
            ->addColumn('aksi', function ($row) {
                $routes = [
                    'AssetsModel' => $row->loggable_type === 'App\Models\AssetsModel'
                        ? $row->event === 'deleted' ? null : route('admin.asettik.overview', $row->loggable_id)
                        : null,
                ];

                $route = null;
                if ($row->loggable_type === 'App\Models\AssetsModel') {
                    $asset = \App\Models\AssetsModel::withTrashed()->find($row->loggable_id);
                    if ($asset) {
                        $route = $asset->classification_id === 2
                            ? route('admin.asettik.overview', $row->loggable_id)
                            : route('admin.asetrt.overview', $row->loggable_id);
                    }
                } elseif ($row->loggable_type === 'App\Models\TicketsModel') {
                    $route = route('admin.tiket.show', $row->loggable_id);
                }

                if ($route) {
                    return '<a href="' . $route . '" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></a>';
                }
                return '<span class="text-muted">-</span>';
            })
            ->filterColumn('user_name', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->filter(function ($query) {
                if (request()->has('module') && !empty(request('module'))) {
                    $map = [
                        'aset' => 'App\Models\AssetsModel',
                        'tiket' => 'App\Models\TicketsModel',
                        'pemeliharaan' => 'App\Models\MaintenancesModel',
                    ];
                    $type = $map[request('module')] ?? null;
                    if ($type) {
                        $query->where('loggable_type', $type);
                    }
                }
                if (request()->has('event') && !empty(request('event'))) {
                    $query->where('event', request('event'));
                }
                if (request()->has('user_id') && !empty(request('user_id'))) {
                    $query->where('user_id', request('user_id'));
                }
                if (request()->has('date_from') && !empty(request('date_from'))) {
                    $query->whereDate('created_at', '>=', request('date_from'));
                }
                if (request()->has('date_to') && !empty(request('date_to'))) {
                    $query->whereDate('created_at', '<=', request('date_to'));
                }
            })
            ->rawColumns(['user_name', 'module', 'event_badge', 'aksi'])
            ->make(true);
    }
}
