<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\JadwalPemeliharaanRequest;
use App\Models\User;
use App\Notifications\CreateJadwalPemeliharaanAsetRT;

class PemeliharaanController extends Controller
{
    public function index($id): View
    {
        $maintenances_schedule = \App\Models\Maintenances_scheduleModel::where('asset_id', $id)->get(); // Menggunakan model Maintenance::with('item')->latest()->get();
        // $assets = \App\Models\AssetsModel::findOrFail($id); // Untuk dropdown di form tambah
        $asset = \App\Models\AssetsModel::findOrFail($id);
        Log::info("Loading Penjadwalan for asset ID: $id");
        return view('admin.detailaset.pemeliharaan', compact('id', 'maintenances_schedule', 'asset'));
    }

    public function scheduleDataTable(Request $request, $id): JsonResponse
    {
        $assets = \App\Models\AssetsModel::get();
        $maintenances_schedule = \App\Models\Maintenances_scheduleModel::where('asset_id', $request->id)->get(); // Menggunakan model Maintenance::with('item')->latest()->get();
        // $maintenances_schedule = \App\Models\Maintenances_scheduleModel::get(); // Menggunakan model Maintenance::with('item')->latest()->get();
        $maintenances = \App\Models\MaintenancesModel::where('maintenance_schedule_id', $request->id)->get();
        return DataTables::of($maintenances_schedule)
            ->addIndexColumn()
            ->addColumn('action', function ($row) use ($maintenances_schedule) {
                return
                    // '<div>
                    // <button class="btn btn-primary" data-id="' . $row->id . '"><i class="fa-regular fa-pen-to-square"></i></button>
                    // <button class="btn btn-danger" data-id="' . $row->id . '"><i class="fa-regular fa-trash-can"></i></button>
                    // </div>'
                    // <li><span class="mx-3" onclick="showModalEditJadwalPemeliharaan(' . $row->id . ')" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-asset="' . $row->asset_id . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                    '
                    <button class="btn btn-outline-primary btn-sm" onclick="showModalAddTugasPreventif(' . $row->id . ')"><i class="fa-regular fa-circle-check"></i> Selesaikan</button>
                    <div class="btn-group">
                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" onclick="showModalEditJadwalPemeliharaan(' . $row->id . ')" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-asset="' . $row->asset_id . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" onclick="deleteJadwalPemeliharaan(' . $row->id . ')" data-id="' . $row->id . '" data-name="' . e($row->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                    '
                    ;
            })
            ->make();
    }

    public function scheduleStore(JadwalPemeliharaanRequest $request, $id): JsonResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('maintenances_schedule')->where(function ($query) use ($id) {
                    return $query->where('asset_id', $id);
                }),
            ],
        ]);
        $data = $request->validated();
        $maintenance_schedule = \App\Models\Maintenances_scheduleModel::create($data);

        // Kirim notifikasi
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['superadmin', 'admin_rt']);
        })->get();
        foreach ($users as $user) {
            $user->notify(new CreateJadwalPemeliharaanAsetRT($maintenance_schedule));
        }
        return response()->json([
            'message' => 'Data saved successfully',
        ]);
    }

    public function scheduleEdit(Request $request, $id): JsonResponse
    {
        $maintenance_schedule = \App\Models\Maintenances_scheduleModel::findOrFail($id);
        return response()->json($maintenance_schedule);
    }

    public function scheduleUpdate(JadwalPemeliharaanRequest $request, $id): JsonResponse
    {
        $maintenance_schedule = \App\Models\Maintenances_scheduleModel::findOrFail($id);
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('maintenances_schedule')->ignore($maintenance_schedule->id)->where(function ($query) use ($maintenance_schedule) {
                    return $query->where('asset_id', $maintenance_schedule->asset_id);
                }),
            ],
        ]);
        $maintenance_schedule->update($request->validated());
        return response()->json([
            'message' => 'Data updated successfully',
        ]);
    }

    public function scheduleDelete(Request $request, $id): JsonResponse
    {
        $maintenance_schedule = \App\Models\Maintenances_scheduleModel::findOrFail($id);
        $maintenance_schedule->delete();
        return response()->json([
            'message' => 'Data deleted successfully',
        ]);
    }

    public function addPreventif(Request $request, $id): JsonResponse
    {
        $maintenance_schedule = \App\Models\Maintenances_scheduleModel::findOrFail($id);
        $asset = \App\Models\AssetsModel::findOrFail($maintenance_schedule->asset_id);
        Log::info("Loading Add Preventif for Maintenance Schedule ID: $maintenance_schedule->name");
        return response()->json(['maintenance_schedule' => $maintenance_schedule, 'asset' => $asset]);
    }

    public function addPreventifStore(Request $request, $id): JsonResponse
    {
        $maintenance_schedule = \App\Models\Maintenances_scheduleModel::findOrFail($id);
        $maintenance = new \App\Models\MaintenancesModel($request->all());
        $maintenance->maintenance_schedule_id = $maintenance_schedule->id;
        $maintenance->asset_id = $maintenance_schedule->asset_id;
        $maintenance->save();

        // Update next_date in maintenance_schedule
        if ($maintenance_schedule->frequency) {
            $nextDate = now()->addMonths($maintenance_schedule->frequency);
            $maintenance_schedule->next_date = $nextDate;
            $maintenance_schedule->save();
        }

        return response()->json([
            'message' => 'Preventif task added successfully',
        ]);
    }

    public function korektifdataTable(Request $request, $id): JsonResponse
    {
        $assets = \App\Models\AssetsModel::get();
        $maintenances_schedule = \App\Models\Maintenances_scheduleModel::where('asset_id', $request->id)->get(); // Menggunakan model Maintenance::with('item')->latest()->get();
        // $maintenances_schedule = \App\Models\Maintenances_scheduleModel::get(); // Menggunakan model Maintenance::with('item')->latest()->get();
        $maintenances = \App\Models\MaintenancesModel::where('maintenance_schedule_id', $request->id)->get();
        return DataTables::of($maintenances)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<div>
                    <button class="btn btn-primary" data-id="' . $row->id . '">Edit</button>
                    <button class="btn btn-danger" data-id="' . $row->id . '">Delete</button>
                    </div>';
            })
            ->make();
    }

    public function getFormData() {}

    public function store(Request $request, $id)
    {
        $maintenance = new \App\Models\MaintenancesModel($request->all());
        $maintenance->asset_id = $id;
        $maintenance->save();
        return redirect()->route('admin.pemeliharaan.index', $id);
    }
}
