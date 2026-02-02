<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PemeliharaanKorektifController extends Controller
{
    public function index(): View
    {
        $maintenances = \App\Models\MaintenancesModel::get();
        $totalPemeliharaan = \App\Models\MaintenancesModel::whereDoesntHave('maintenance_schedule')->where('status', '!=', 'Selesai')->count();
        $totalPemeliharaanSelesai = \App\Models\MaintenancesModel::whereDoesntHave('maintenance_schedule')->where('status', 'Selesai')->count();
        // untuk dropdown
        $users = \App\Models\User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'superadmin');
        })->get();
        // $users = \App\Models\User::get();
        $assets = \App\Models\AssetsModel::get();
        $projects = \App\Models\ProjectsModel::get();
        return view('admin.pemeliharaan-korektif.index', compact('maintenances', 'totalPemeliharaan', 'totalPemeliharaanSelesai', 'users', 'assets', 'projects'));
    }

    public function pemeliharaanDataTable(Request $request): JsonResponse
    {
        // relasi ke user agar bisa menampilkan nama PIC
        $maintenances = \App\Models\MaintenancesModel::with('pic', 'asset')
            ->whereDoesntHave('maintenance_schedule')
            ->where('status', '!=', 'Selesai')
            ->get();

        return DataTables::of($maintenances)
            ->addIndexColumn()
            ->addColumn('pic', function ($maintenances) {
                return e($maintenances->pic->fullname ?? '-');
            })
            ->addColumn('action', function ($row) {
                return
                    // <button id="cekTindakLanjut" class="btn btn-outline-primary btn-sm" onclick="openTindakLanjut(' . $row->id . ')" data-toggle="tooltip" data-placement="top" title="Tindak Lanjut"><i class="fa-regular fa-circle-check"></i> TL</button>
                    // @if($row->status == 'Segera Kerjakan')
                    //     <button id="cekTindakLanjut" class="btn btn-outline-primary btn-sm" onclick="showModalUbahStatus(' . $row->id . ')" data-toggle="tooltip" data-placement="top" title="Tindak Lanjut"><i class="fa-regular fa-circle-check"></i> TL</button>
                    // @else
                    //     <button id="cekTindakLanjut" class="btn btn-outline-primary btn-sm" onclick="showModalTindakLanjut(' . $row->id . ')" data-toggle="tooltip" data-placement="top" title="Tindak Lanjut"><i class="fa-regular fa-circle-check"></i> TL</button>
                    // @endif
                    // bikin if else untuk tombol tindak lanjut
                    '
                <div class="btn-group">
                    ' .
                    (($row->status == "Segera Kerjakan") ?
                        '<a id="cekTindakLanjut" class="btn btn-light" style="color: green" onclick="showModalUbahStatus(' . $row->id . ')" data-toggle="tooltip" data-placement="top" title="Tindak Lanjut"><i class="fa-solid fa-spinner"></i> TL</a>' :
                        '<a id="cekTindakLanjut" class="btn btn-light" style="color: green" onclick="showModalTindakLanjut(' . $row->id . ')" data-toggle="tooltip" data-placement="top" title="Tindak Lanjut"><i class="fa-regular fa-circle-check"></i> TL</a>'
                    )
                    .
                    '<div class="btn-group">
                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><span class="mx-3" onclick="showModalEditPemeliharaan(' . $row->id . ')" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-asset="' . $row->asset_id . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                    <li><span class="mx-3" onclick="deletePemeliharaan(' . $row->id . ')" data-id="' . $row->id . '" data-name="' . e($row->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                    </ul>
                    </div>
                </div>'

                ;
            })
            ->make();
    }
    public function pemeliharaanDataTableSelesai(Request $request): JsonResponse
    {
        // buatdatatable yang hanya statusnya selesai
        $maintenancesSelesai = \App\Models\MaintenancesModel::with('pic', 'asset')
            ->whereDoesntHave('maintenance_schedule')
            ->where('status', 'Selesai')
            ->get();
        return DataTables::of($maintenancesSelesai)
            ->addIndexColumn()
            ->addColumn('pic', function ($maintenancesSelesai) {
                return e($maintenancesSelesai->pic->fullname ?? '-');
            })
            ->addColumn('action', function ($row) {
                return
                    '
                    <div class="btn-group">

                        <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><span class="mx-3" onclick="showModalEditPemeliharaan(' . $row->id . ')" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-asset="' . $row->asset_id . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                                <li><span class="mx-3" onclick="deletePemeliharaan(' . $row->id . ')" data-id="' . $row->id . '" data-name="' . e($row->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                            </ul>
                        </div>
                    </div>
                        ';
            })
            ->make();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'issuetype' => 'required|string|max:100',
            'asset_id' => 'required|exists:assets,id',
            'pic_id' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'status' => 'required|string|max:50',
            'priority' => 'required|string|max:50',
            'duedate' => 'required|date',
            'created_by' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'issuetype' => $request->issuetype,
                'asset_id' => $request->asset_id,
                'pic_id' => $request->pic_id,
                'project_id' => $request->project_id,
                'status' => $request->status,
                'priority' => $request->priority,
                'duedate' => $request->duedate,
                'created_by' => $request->created_by,
                'notes' => $request->notes,
            ];

            $maintenance = \App\Models\MaintenancesModel::create($data);

            return response()->json(['message' => 'Pemeliharaan korektif berhasil ditambahkan.', 'data' => $maintenance], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Pemeliharaan korektif gagal ditambahkan.'], 500);
        }
    }

    public function edit(Request $request, $id): JsonResponse
    {
        $maintenance = \App\Models\MaintenancesModel::findOrFail($id);
        return response()->json($maintenance);
    }

    public function ubahStatus(Request $request, $id): JsonResponse
    {
        $maintenance = \App\Models\MaintenancesModel::findOrFail($id);

        $request->validate([
            'status' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $maintenance->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'started_at' => now()
        ]);

        return response()->json(['message' => 'Status pemeliharaan berhasil diubah.']);
    }

    public function tindakLanjut(Request $request, $id): JsonResponse
    {
        $maintenance = \App\Models\MaintenancesModel::findOrFail($id);
        // tangani cost agar menghilangkan format Rp dan titik koma jika ada
        if ($request->has('cost')) {
            $cost = preg_replace('/[^\d]/', '', $request->input('cost'));
            $request->merge(['cost' => $cost]);
        }
        $request->validate([
            'attachment' => 'required|file|mimes:jpg,jpeg,png,heic,heif,pdf|max:2048', // max 2MB
            'cost' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
            'notes' => 'required|string',
            'completed_at' => 'nullable|date',
        ]);

        // PENANGANAN FILE
        $file_path = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            // Tentukan folder penyimpanan, misalnya: 'public/uploads/korektif_attachment'
            $folder = 'korektif_attachment';

            // Simpan file ke disk, Laravel akan secara otomatis membuat nama unik
            // dan mengembalikan path relatif ke folder disk.
            // Gunakan 'public' disk untuk file yang bisa diakses publik
            $file_path = $file->store($folder, 'public');
        }

        try {
            $data = [
                'attachment' => $file_path,
                'cost' => $request->cost,
                'status' => $request->status,
                'notes' => $request->notes,
                'completed_at' => now(),
            ];
            $maintenance->update($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui pemeliharaan.',
                'error' => $e->getMessage(),
            ], 500);
        }

        if ($file_path) {
            $maintenance->update([
                'attachment' => $file_path
            ]);
        } else {
            $maintenance->update([
                'attachment' => null
            ]);
        }

        $maintenance->update($data);

        return response()->json(['message' => 'Status pemeliharaan berhasil diubah.', 'data' => $maintenance], 200);
    }


}
