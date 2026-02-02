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
                    '
                    <button class="btn btn-outline-primary btn-sm" onclick="showModalAddPreventif(' . $row->id . ')" data-toggle="tooltip" data-placement="top" title="Tindak Lanjut"><i class="fa-regular fa-circle-check"></i> TL</button>
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

    public function preventifDataTable(Request $request, $id): JsonResponse
    {
        $assets = \App\Models\AssetsModel::get();
        $maintenances_schedule = \App\Models\Maintenances_scheduleModel::where('asset_id', $request->id)->get(); // Menggunakan model Maintenance::with('item')->latest()->get();
        // perbaiki variable $maintenances agar dapat menampilkan data yang benar dengan klausa maintenance_schedule_id nya yang berisi asset_id dari $request->id
        $maintenances = \App\Models\MaintenancesModel::whereHas('maintenance_schedule', function ($query) use ($request) {
            $query->where('asset_id', $request->id);
        })->get();

        return DataTables::of($maintenances)
            ->addIndexColumn()
            ->addColumn('pic', function ($maintenances) {
                return e($maintenances->pic->username ?? '-');
            })
            ->addColumn('action', function ($row) {
                return
                    '
                    <div class="btn-group">
                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" onclick="showModalEditPreventif(' . $row->id . ')" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-asset="' . $row->asset_id . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" onclick="deletePreventif(' . $row->id . ')" data-id="' . $row->id . '" data-name="' . e($row->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                    '
                    ;
            })
            ->make();
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
            'attachment' => 'required|file|mimes:jpg,jpeg,png,heic,heif,pdf|max:10240', // Maks 10MB
            'name' => 'required|string', // Untuk checkbox
            'period' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'notes' => 'required|string',
        ], [
            'attachment.required' => 'Bukti dukung wajib diupload.',
            'attachment.mimes' => 'Format file tidak didukung.',
            'attachment.max' => 'Ukuran file maksimal 10MB.',
            'name.required' => 'Wajib mencentang bahwa pemeliharaan selesai.',
            'period.required' => 'Periode wajib diisi.',
            'cost.required' => 'Biaya wajib diisi.',
            'notes.required' => 'Catatan wajib diisi.',
        ]);

        // 2. PENANGANAN FILE
        $file_path = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            // Tentukan folder penyimpanan, misalnya: 'public/uploads/preventif_attachment'
            $folder = 'preventif_attachment';

            // Simpan file ke disk, Laravel akan secara otomatis membuat nama unik
            // dan mengembalikan path relatif ke folder disk.
            // Gunakan 'public' disk untuk file yang bisa diakses publik
            $file_path = $file->store($folder, 'public');
        }

        // 3. PENYIMPANAN DATA KE DATABASE
        try {
            $data = [
                'name' => $request->input('name'),
                'maintenance_schedule_id' => $id, // Relasi ke jadwal pemeliharaan
                'pic_id' => auth()->id(), // Siapa yang menyelesaikan
                'status' => 'Selesai',
                'started_at' => now(), // Waktu penyelesaian
                'completed_at' => now(), // Waktu penyelesaian
                'period' => $request->input('period'),
                'cost' => $request->input('cost'), // Biaya pemeliharaan
                'attachment' => $file_path, // Simpan path file
                'notes' => $request->input('notes'), // Catatan tambahan
            ];
            $maintenance = \App\Models\MaintenancesModel::create($data);

            // 4. RESPON BERHASIL
            return response()->json([
                'message' => 'Anda telah menyelesaikan pemeliharaan.'
            ]);

        } catch (\Exception $e) {
            // 5. RESPON GAGAL
            return response()->json([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function preventifEdit(Request $request, $id): JsonResponse
    {
        $maintenances = \App\Models\MaintenancesModel::findOrFail($id);
        $asset = \App\Models\AssetsModel::findOrFail($maintenances->maintenance_schedule->asset_id);
        // bagaimana caranya mengambil data dari maintenance_schedule asset_id untuk ditampilkan nama assetnya di modal edit preventif
        $maintenances->asset_name = $asset->name;
        Log::info("Loading Edit Preventif for Maintenance Name: $maintenances->name (ID: $id)");
        return response()->json($maintenances);
    }

    public function preventifDelete(Request $request, $id): JsonResponse
    {
        $maintenances = \App\Models\MaintenancesModel::findOrFail($id);
        $maintenances->delete();
        return response()->json([
            'message' => 'Data pemeliharaan preventif berhasil dihapus.',
        ]);
    }

    public function korektifdataTable(Request $request, $id): JsonResponse
    {
        $assets = \App\Models\AssetsModel::get();
        $maintenances_schedule = \App\Models\Maintenances_scheduleModel::where('asset_id', $request->id)->get(); // Menggunakan model Maintenance::with('item')->latest()->get();
        $maintenances = \App\Models\MaintenancesModel::whereDoesntHave('maintenance_schedule')
            ->where('asset_id', $request->id)
            ->get();
        return DataTables::of($maintenances)
            ->addIndexColumn()
            ->addColumn('pic', function ($maintenances) {
                return e($maintenances->pic->username ?? '-');
            })
            ->addColumn('action', function ($row) {
                return
                '
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

    public function getFormData() {}

    public function store(Request $request, $id)
    {
        $maintenance = new \App\Models\MaintenancesModel($request->all());
        $maintenance->asset_id = $id;
        $maintenance->save();
        return redirect()->route('admin.pemeliharaan.index', $id);
    }
}
