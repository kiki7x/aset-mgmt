<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\JadwalPemeliharaanRequest;
use App\Models\User;
use App\Notifications\CreatePemeliharaanAsetRT;

class PemeliharaanController extends Controller
{
    public function index($id): View
    {
        $maintenances_schedule = \App\Models\Maintenances_scheduleModel::where('asset_id', $id)->get(); // Menggunakan model Maintenance::with('item')->latest()->get();
        // $assets = \App\Models\AssetsModel::findOrFail($id); // Untuk dropdown di form tambah
        $asset = \App\Models\AssetsModel::findOrFail($id);
        Log::info("Loading Penjadwalan for asset ID: $id");
        return view('admin.components.pemeliharaan', compact('id', 'maintenances_schedule', 'asset'));
    }

    public function preventifdataTable(Request $request, $id)
    {
        $assets = \App\Models\AssetsModel::get();
        $maintenances_schedule = \App\Models\Maintenances_scheduleModel::where('asset_id', $request->id)->get(); // Menggunakan model Maintenance::with('item')->latest()->get();
        // $maintenances_schedule = \App\Models\Maintenances_scheduleModel::get(); // Menggunakan model Maintenance::with('item')->latest()->get();
        $maintenances = \App\Models\MaintenancesModel::where('maintenance_schedule_id', $request->id)->get();
        return DataTables::of($maintenances_schedule)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<div>
                    <button class="btn btn-primary" data-id="' . $row->id . '"><i class="fa-regular fa-pen-to-square"></i></button>
                    <button class="btn btn-danger" data-id="' . $row->id . '"><i class="fa-regular fa-trash-can"></i></button>
                    </div>';
            })
            ->make();
    }

    public function preventifStore(JadwalPemeliharaanRequest $request, $id)
    {
        $data = $request->validated();
        // $maintenance_schedule = new \App\Models\Maintenances_scheduleModel($data);
        // $maintenance_schedule->asset_id = $id;
        // $maintenance_schedule->save();
        $maintenance_schedule = \App\Models\Maintenances_scheduleModel::create($data);

        // Kirim notifikasi
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['superadmin', 'admin_rt']);
        })->get();

        foreach ($users as $user) {
            $user->notify(new CreatePemeliharaanAsetRT($maintenance_schedule));
        }

        return response()->json([
            'message' => 'Data saved successfully',
        ]);
    }

    public function korektifdataTable(Request $request, $id)
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
