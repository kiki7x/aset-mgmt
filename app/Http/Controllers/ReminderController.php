<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Maintenances_scheduleModel;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ReminderController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('username')->get();
        return view('admin.reminder.index', compact('users'));
    }

    public function data(): JsonResponse
    {
        $schedules = Maintenances_scheduleModel::with('asset', 'asset.classification')
            ->where('status', 'Aktif')
            ->whereNotNull('reminder')
            ->latest();

        return DataTables::of($schedules)
            ->addColumn('asset_name', function ($row) {
                return e($row->asset?->name ?? '-');
            })
            ->addColumn('classification', function ($row) {
                return e($row->asset?->classification?->name ?? '-');
            })
            ->addColumn('jatuh_tempo', function ($row) {
                return $row->end ? \Carbon\Carbon::parse($row->end)->format('d M Y') : '-';
            })
            ->addColumn('reminder_hari', function ($row) {
                return $row->reminder ? 'H-' . $row->reminder : '-';
            })
            ->addColumn('status_kirim', function ($row) {
                if (!$row->last_reminder_sent_at) {
                    return '<span class="badge badge-secondary">Pending</span>';
                }
                $lastSent = \Carbon\Carbon::parse($row->last_reminder_sent_at);
                if ($lastSent->isToday()) {
                    return '<span class="badge badge-success">Terkirim Hari Ini</span>';
                }
                return '<span class="badge badge-info">Terkirim ' . $lastSent->format('d M Y') . '</span>';
            })
            ->addColumn('aksi', function ($row) {
                if ($row->asset) {
                    $route = $row->asset->classification_id === 2
                        ? route('admin.asettik.overview', $row->asset_id)
                        : route('admin.asetrt.overview', $row->asset_id);
                    return '<a href="' . $route . '" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></a>';
                }
                return '-';
            })
            ->filter(function ($query) {
                if (request()->has('status') && !empty(request('status'))) {
                    $status = request('status');
                    if ($status === 'sent') {
                        $query->whereNotNull('last_reminder_sent_at');
                    } elseif ($status === 'pending') {
                        $query->whereNull('last_reminder_sent_at');
                    }
                }
                if (request()->has('classification') && !empty(request('classification'))) {
                    $query->whereHas('asset', function ($q) {
                        $q->where('classification_id', request('classification'));
                    });
                }
            })
            ->rawColumns(['status_kirim', 'aksi'])
            ->make(true);
    }
}
