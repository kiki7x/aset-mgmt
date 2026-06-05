<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Models\AssetcategoriesModel;
use App\Models\AssetsModel;
use App\Models\LabelsModel;
use App\Models\LocationsModel;
use App\Models\ManufacturersModel;
use App\Models\ModelsModel;
use App\Models\SuppliersModel;
use App\Models\User;
use App\Notifications\CreateAsetRT;
use App\Notifications\CreateAsetTik;
use App\Notifications\EditAsetRT;
use App\Notifications\EditAsetTik;
use App\Notifications\DeleteAsetRT;
use App\Notifications\DeleteAsetTik;
use Yajra\DataTables\Facades\DataTables;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLSXGen;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    public $prefix_tik = "tik";
    public $prefix_rt = "rt";
    public $classification_tik_id = "2";
    public $classification_rt_id = "3";
    public $client_id = 1;

    public function index_tik(): View
    {
        $manufacturers = ManufacturersModel::get();
        $models = ModelsModel::get();
        $suppliers = SuppliersModel::get();
        $locations = LocationsModel::get();
        $statuses = LabelsModel::get();
        $users = User::get();
        $categories = AssetcategoriesModel::whereIn('classification_id', [2])->get();
        $totalAssets = AssetsModel::where('classification_id', 2)->count();

        return view('admin.asettik.index', compact(
            'categories',
            'manufacturers',
            'models',
            'suppliers',
            'locations',
            'statuses',
            'users',
            'totalAssets'
        ));
    }

    public function index_rt(): View
    {
        $manufacturers = ManufacturersModel::get();
        $models = ModelsModel::get();
        $suppliers = SuppliersModel::get();
        $locations = LocationsModel::get();
        $statuses = LabelsModel::get();
        $users = User::get();

        $categories = AssetcategoriesModel::whereIn('classification_id', [3, 4])->get();

        $assets = AssetsModel::with('category', 'status', 'model', 'user')->where('classification_id', 2)->latest()->paginate(10);

        $totalAssets = AssetsModel::whereIn('classification_id', [3, 4])->count();

        return view('admin.asetrt.index', compact(
            'assets',
            'categories',
            'manufacturers',
            'models',
            'suppliers',
            'locations',
            'statuses',
            'users',
            'totalAssets'
        ));
    }

    public function get_assets(Request $request): JsonResponse
    {
        $category = $request->category;
        $classification = $request->classification;
        $maintenances_schedule = \App\Models\Maintenances_scheduleModel::get();

        if ($classification === "tik") {
            $routePrefix = "asettik";
        }

        if ($classification === "rt") {
            $routePrefix = "asetrt";
        }

        $assets = AssetsModel::with('category', 'status', 'model', 'user')
            ->when($classification === 'tik', fn($q) => $q->where('classification_id', 2))
            ->when($classification === 'rt', fn($q) => $q->whereIn('classification_id', [3, 4]))
            ->when($category, fn($query) => $query->where('category_id', $category))
            ->latest();

        return DataTables::of($assets)
            ->addIndexColumn()
            ->filterColumn('name', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                        ->orWhere('serial', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('tag', function ($asset) use ($routePrefix) {
                return '<a href="' . route("admin.$routePrefix.overview", $asset->id) . '">' . e($asset->tag) . '</a>';
            })
            ->addColumn('name', function ($asset) use ($routePrefix) {
                return '
                <a href="' . route("admin.$routePrefix.overview", ['id' => $asset->id]) . '" class="font-weight-bold">' . e($asset->name) . '</a><br>
                <span class="text-muted">Serial No: </span>' . e($asset->serial) . '<br>
                <span class="text-muted">Status: </span>
                <span class="badge" style="background-color: ' . e($asset->status->color ?? '#999') . '; color: white;">' . e($asset->status->name ?? '-') . '</span> <br>
                <span class="text-muted">Lokasi: </span>
                ' . e($asset->location->name ?? '-') . '<br>
                <span class="text-muted">Dikelola oleh: </span>
                ' . e($asset->admin->fullname ?? '-') . '<br>
                <span class="text-muted">Tahun Perolehan: </span>' . e( Carbon::parse($asset->purchase_date)->format('Y')) . '<br>
            ';
            })
            ->addColumn('category', function ($asset) {
                return '
                <span class="badge" style="border:1px solid ' . e($asset->category->color ?? '#ccc') . '; color:' . e($asset->category->color ?? '#000') . ';">
                    ' . e($asset->category->name ?? '-') . '
                </span>';
            })
            ->addColumn('model', function ($asset) {
                return e($asset->model->name ?? '-');
            })
            ->addColumn('user', function ($asset) {
                return e($asset->user->username ?? '-');
            })
            ->addColumn('timestamp', function ($asset) {
                return $asset->updated_at;
            })
            ->addColumn('action', function ($asset) use ($classification , $maintenances_schedule) {
                return '
                <div class="btn-group">
                    <a href="' . route('admin.asetrt.pemeliharaan', ['id' => $asset->id]) . '" class="btn btn-light">'
                    . ( $maintenances_schedule->where('asset_id', $asset->id)->count() > 0  ? '<i class="fa-regular fa-calendar-check" style="color: green" title="Jadwal Pemeliharaan"></i>' : '<i class="fa-regular fa-calendar-minus" style="color: grey" title="Jadwal Pemeliharaan"></i>' ) . '
                    </a>
                    <span class="btn btn-light" style="color: blue" data-toggle="modal" data-target="#qrCodeModal" data-tag="' . $asset->tag . '" data-name="' . e($asset->name) . '">
                        <i class="fas fa-qrcode"></i>
                    </span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                    <a class="mx-3" href="' . (
                    $classification === 'tik'
                    ? route('admin.asettik.edit', ['id' => $asset->id])
                    : route("admin.asetrt.edit", ['id' => $asset->id])
                ) . '">Edit</a>
                </li>
                            <li><span class="mx-3" data-toggle="modal" data-target="#deleteModal" data-id="' . $asset->id . '" data-name="' . e($asset->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                </div>
            ';
            })
            ->rawColumns(['tag', 'name', 'category', 'model', 'user', 'timestamp', 'action'])
            ->make(true);
    }

    public function store(Request $request, $classification): JsonResponse
    {
        // 1. Validasi
        $request->validate(
            [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:assetcategories,id',
            'manufacturer_id' => 'required|array|min:1|max:1',
            'manufacturer_id.0' => 'required',
            'model_id' => 'required|array|min:1|max:1',
            'model_id.0' => 'required',
            'supplier_id' => 'required|array|min:1|max:1',
            'supplier_id.0' => 'required',
            'serial' => 'required|unique:assets|string|max:255',
            'location_id' => 'required|integer|exists:locations,id',
            'status_id' => 'required|integer|exists:labels,id',
            'user_id' => 'required|integer|exists:users,id',
            'purchase_date' => 'required|date',
            'warranty_months' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],
            [
            'name.required' => 'Nama aset wajib diisi.',
            'name.string' => 'Nama aset harus berupa teks.',
            'name.max' => 'Nama aset tidak boleh lebih dari :max karakter.',

            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.integer' => 'Kategori harus berupa angka.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',

            'manufacturer_id.required' => 'Merk/Pabrikan wajib dipilih.',
            'manufacturer_id.array' => 'Merk/Pabrikan harus berupa array.',
            'manufacturer_id.min' => 'Pilih salah satu merk/pabrikan.',
            'manufacturer_id.max' => 'Hanya boleh memilih satu merk/pabrikan.',

            'manufacturer_id.0.required' => 'Merk/Pabrikan wajib dipilih.',
            'manufacturer_id.0.exists' => 'Merk/Pabrikan yang dipilih tidak ditemukan.',

            'model_id.required' => 'Tipe/Model wajib dipilih.',
            'model_id.array' => 'Tipe/Model harus berupa array.',
            'model_id.min' => 'Pilih salah satu tipe/model.',
            'model_id.max' => 'Hanya boleh memilih satu tipe/model.',

            'model_id.0.required' => 'Tipe/Model wajib dipilih.',
            'model_id.0.exists' => 'Tipe/Model yang dipilih tidak ditemukan.',

            'supplier_id.required' => 'Supplier wajib dipilih.',
            'supplier_id.array' => 'Supplier harus berupa array.',
            'supplier_id.min' => 'Pilih salah satu supplier.',
            'supplier_id.max' => 'Hanya boleh memilih satu supplier.',

            'supplier_id.0.required' => 'Supplier wajib dipilih.',
            'supplier_id.0.exists' => 'Supplier yang dipilih tidak ditemukan.',

            'serial.required' => 'Nomor seri wajib diisi.',
            'serial.unique' => 'Nomor seri sudah digunakan.',
            'serial.string' => 'Nomor seri harus berupa teks.',
            'serial.max' => 'Nomor seri tidak boleh lebih dari :max karakter.',

            'location_id.required' => 'Penempatan wajib dipilih.',
            'location_id.integer' => 'Penempatan tidak valid.',
            'location_id.exists' => 'Penempatan yang dipilih tidak ditemukan.',

            'status_id.required' => 'Status wajib dipilih.',
            'status_id.integer' => 'Status tidak valid.',
            'status_id.exists' => 'Status yang dipilih tidak ditemukan.',

            'user_id.required' => 'Pengguna aset wajib dipilih.',
            'user_id.integer' => 'Pengguna tidak valid.',
            'user_id.exists' => 'Pengguna yang dipilih tidak ditemukan.',

            'purchase_date.required' => 'Tanggal perolehan wajib diisi.',
            'purchase_date.date' => 'Tanggal perolehan tidak valid.',

            'warranty_months.required' => 'Masa garansi wajib diisi.',
            'warranty_months.integer' => 'Masa garansi harus berupa angka.',
            'warranty_months.min' => 'Masa garansi tidak boleh kurang dari 0 bulan.',

            'notes.string' => 'Catatan harus berupa teks.',
        ]
        );
        if ($classification === "tik") {
            $prefix = $this->prefix_tik;
            $classification_id = $this->classification_tik_id;
            $sendNotificationByRole = ['superadmin', 'admin_tik', 'staf_tik'];
            $notificationClass = CreateAsetTik::class;
        }

        if ($classification === "rt") {
            $prefix = $this->prefix_rt;
            $classification_id = $this->classification_rt_id;
            $sendNotificationByRole = ['superadmin', 'admin_rt'];
            $notificationClass = CreateAsetRT::class;
        }

        $checkTag = $this->incrementTag($classification);
        $newTag = $prefix . '-' . $checkTag;

        $ceksupplier = SuppliersModel::firstOrNew(["id" => (int) $request->supplier_id[0]], ["name" => $request->supplier_id[0]]);
        $ceksupplier->save();
        $request->merge(["supplier_id" => $ceksupplier->id]);

        $cekmanufacturer = ManufacturersModel::firstOrNew(["id" => (int) $request->manufacturer_id[0]], ["name" => $request->manufacturer_id[0]]);
        $cekmanufacturer->save();
        $request->merge(["manufacturer_id" => $cekmanufacturer->id]);

        $cekmodel = ModelsModel::firstOrNew(["id" => (int) $request->model_id[0]], ["name" => $request->model_id[0]]);
        $cekmodel->save();
        $request->merge(["model_id" => $cekmodel->id]);

        $data = [
            'classification_id' => $classification_id,
            'category_id' => $request->category_id,
            'admin_id' => auth()->user()->id,
            'client_id' => $this->client_id,
            'user_id' => $request->user_id,
            'manufacturer_id' => (int) $request->manufacturer_id,
            'model_id' => (int) $request->model_id,
            'supplier_id' => (int) $request->supplier_id,
            'status_id' => (int) $request->status_id,
            'purchase_date' => $request->purchase_date,
            'warranty_months' => (int) $request->warranty_months,
            'tag' => $newTag,
            'name' => $request->name,
            'serial' => $request->serial,
            'notes' => $request->notes,
            'location_id' => (int) $request->location_id,
            'customfields' => $request->customfields,
            'qrvalue' => $request->qrvalue,
        ];

        // handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('assets/images', 'public');
            $data['image'] = $imagePath;
        }

        // simpan
        $asset = AssetsModel::Create($data);

        // kirim notifikasi
        $users = User::whereHas('roles', function ($query) use ($sendNotificationByRole) {
            $query->whereIn('name', $sendNotificationByRole);
        })->get();

        foreach ($users as $user) {
            $user->notify(new $notificationClass($asset));
        }

        return response()->json([
            'message' => 'Data berhasil disimpan.',
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        // VALIDASI
        $request->validate([
            'id' => 'required',
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'manufacturer_id' => 'required|array|min:1|max:1',
            'manufacturer_id.0' => 'required',
            'model_id' => 'required|array|min:1|max:1',
            'model_id.0' => 'required',
            'supplier_id' => 'required|array|min:1|max:1',
            'supplier_id.0' => 'required',
            'serial' => [
                'required',
                Rule::unique('assets', 'serial')->ignore($id),
            ],
            'location_id' => 'required',
            'status_id' => 'required',
            'user_id' => 'required',
            'admin_id' => 'required',
            'purchase_date' => 'required|date',
            'warranty_months' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 1. cek asset
        $asset = AssetsModel::findOrFail($id);
        $classification_id = $asset->classification_id;

        // 2. cek klasifikasi
        if ($classification_id === 2) {
            $prefix = $this->prefix_tik;
            $sendNotificationByRole = ['superadmin', 'admin_tik', 'staf_tik'];
            $notificationClass = EditAsetTik::class;
        } elseif ($classification_id === 3 || $classification_id === 4) {
            $prefix = $this->prefix_rt;
            $sendNotificationByRole = ['superadmin', 'admin_rt', 'staf_driver', 'staf_engineering'];
            $notificationClass = EditAsetRT::class;
        } else {
            return response()->json(['error' => 'Invalid classification'], 400);
        }
        // 3. cek supplier
        $ceksupplier = SuppliersModel::firstOrNew(["id" => (int) $request->supplier_id[0]], ["name" => $request->supplier_id[0]]);
        $ceksupplier->save();
        $request->merge(["supplier_id" => $ceksupplier->id]);
        // 4. cek manufacturer
        $cekmanufacturer = ManufacturersModel::firstOrNew(["id" => (int) $request->manufacturer_id[0]], ["name" => $request->manufacturer_id[0]]);
        $cekmanufacturer->save();
        $request->merge(["manufacturer_id" => $cekmanufacturer->id]);
        // 5. cek model
        $cekmodel = ModelsModel::firstOrNew(["id" => (int) $request->model_id[0]], ["name" => $request->model_id[0]]);
        $cekmodel->save();
        $request->merge(["model_id" => $cekmodel->id]);

        // 6. buat fungsi image upload
        $imagePath = $asset->image; // gunakan image lama jika tidak ada upload baru
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('assets/images', 'public');
            $request->merge(['image' => $imagePath]);
        }

        // 7. update
        try {
            $data = [
            'client_id' => $this->client_id,
            'tag' => $request->tag,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'location_id' => $request->location_id,
            'manufacturer_id' => $request->manufacturer_id,
            'model_id' => $request->model_id,
            'serial' => $request->serial,
            'status_id' => $request->status_id,
            'user_id' => $request->user_id,
            'admin_id' => $request->admin_id,
            'purchase_date' => $request->purchase_date,
            'warranty_months' => $request->warranty_months,
            'notes' => $request->notes,
            'image' => $imagePath,
            'customfields' => $request->customfields,
            'qrvalue' => $request->qrvalue,
        ];
        // update
            AssetsModel::where('id', $id)->update($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        // test kirim notifikasi
        $users = User::whereHas('roles', function ($query) use ($sendNotificationByRole) {
            $query->whereIn('name', $sendNotificationByRole);
        })->get();

        foreach ($users as $user) {
            $user->notify(new $notificationClass($asset));
        }
        return response()->json(['success' => 'Asset updated successfully']);
    }

    public function destroy($id, $classification)
    {
        if ($classification === "tik") {
            $sendNotificationByRole = ['superadmin', 'admin_tik', 'staf_tik'];
            $notificationClass = DeleteAsetTik::class;
        }

        if ($classification === "rt") {
            $sendNotificationByRole = ['superadmin', 'admin_rt'];
            $notificationClass = DeleteAsetRT::class;
        }

        $asset = AssetsModel::findOrFail($id);

        // kirim notifikasi
        $users = User::whereHas('roles', function ($query) use ($sendNotificationByRole) {
            $query->whereIn('name', $sendNotificationByRole);
        })->get();

        foreach ($users as $user) {
            $user->notify(new $notificationClass($asset));
        }

        $asset->delete();
    }

    public function exportExcelTik()
    {
        $assets = AssetsModel::with(
            'classification',
            'category',
            'user',
            'admin',
            'manufacturer',
            'model',
            'supplier',
            'status',
            'location'
            )
            ->where('classification_id', 2)
            ->get();
            $data = [
                [
                    'id',
                    'Tag',
                    'Klasifikasi',
                    'Nama',
                    'Kategori',
                    'Pengelola',
                    'Pengguna',
                    'Merk/Pabrikan',
                    'Model',
                    'Supplier',
                    'Serial',
                    'Status',
                    'Lokasi',
                    'Tanggal Perolehan',
                    'Garansi (Month)',
                    'Serial Number',
                    'Notes'
                    ]
            ];

            foreach ($assets as $asset) {
                $data[] = [
                    $asset->id,
                    $asset->tag,
                    $asset->classification->name ?? '-',
                    $asset->name,
                    $asset->category->name ?? '-',
                    $asset->admin->fullname ?? '-',
                    $asset->user->fullname ?? '-',
                    $asset->manufacturer->name ?? '-',
                    $asset->model->name ?? '-',
                    $asset->supplier->name ?? '-',
                    $asset->serial,
                    $asset->status->name ?? '-',
                    $asset->location->name ?? '-',
                    // format ulang date
                    Carbon::parse($asset->purchase_date)->format('d-m-Y'),
                    $asset->warranty_months,
                    $asset->serial,
                    $asset->notes
                ];
            }
        // return SimpleXLSXGen::fromArray($data)->downloadAs('asettik.xlsx');
        $date = Carbon::now()->format('d-m-Y');
        return SimpleXLSXGen::fromArray($data)->downloadAs("{$date}_sapa-ppl-aset-tik.xlsx");
    }

    public function exportExcelRt()
    {
        $assets = AssetsModel::with(
            'classification',
            'category',
            'user',
            'admin',
            'manufacturer',
            'model',
            'supplier',
            'status',
            'location'
            )
            ->whereIn('classification_id', [3, 4])
            ->get();
            $data = [
                [
                    'id',
                    'Tag',
                    'Klasifikasi',
                    'Name',
                    'Category',
                    'Pengelola',
                    'Pengguna',
                    'Merk/Pabrikan',
                    'Model',
                    'Supplier',
                    'Serial',
                    'Status',
                    'Lokasi',
                    'Tanggal Perolehan',
                    'Garansi (Month)',
                    'Serial Number',
                    'Notes'
                    ]
            ];

            foreach ($assets as $asset) {
                $data[] = [
                    $asset->id,
                    $asset->tag,
                    $asset->classification->name ?? '-',
                    $asset->name,
                    $asset->category->name ?? '-',
                    $asset->admin->fullname ?? '-',
                    $asset->user->fullname ?? '-',
                    $asset->manufacturer->name ?? '-',
                    $asset->model->name ?? '-',
                    $asset->supplier->name ?? '-',
                    $asset->serial,
                    $asset->status->name ?? '-',
                    $asset->location->name ?? '-',
                    // format ulang date
                    Carbon::parse($asset->purchase_date)->format('d-m-Y'),
                    $asset->warranty_months,
                    $asset->serial,
                    $asset->notes
                ];
            }
            $date = Carbon::now()->format('d-m-Y');
        return SimpleXLSXGen::fromArray($data)->downloadAs( "{$date}_sapa-ppl-asetrt.xlsx");
    }

    public function importExcelTik(Request $request)
    {
        if ($xlsx = SimpleXLSX::parse($request->file('file'))) {
            $rows = $xlsx->rows();
            array_shift($rows); // Menghapus baris pertama (header)

            foreach ($rows as $row) {
                $data = [
                    'client_id' => $this->client_id,
                    'tag' => $row[0],
                    'name' => $row[1],
                    'category_id' => $row[2],
                    'supplier_id' => $row[3],
                    'location_id' => $row[4],
                    'manufacturer_id' => $row[5],
                    'model_id' => $row[6],
                    'serial' => $row[7],
                    'status_id' => $row[8],
                    'user_id' => $row[9],
                    'admin_id' => $row[10],
                    'purchase_date' => $row[11],
                    'warranty_months' => $row[12],
                    'notes' => $row[13],
                    'customfields' => $row[14],
                    'qrvalue' => $row[15],
                ];
            }
        }
    }

    public function incrementTag($classification)
    {
        if ($classification === 'tik') {
            $prefix = $this->prefix_tik;
        }

        if ($classification === 'rt') {
            $prefix = $this->prefix_rt;
        }

        $lastTag = AssetsModel::where('tag', 'like', $prefix . '-%')
            ->orderByRaw("CAST(SUBSTRING_INDEX(tag, '-', -1) AS UNSIGNED) DESC")
            ->first();

        if ($lastTag) {
            $lastSequenceNumber = (int) str_replace($prefix . '-', '', $lastTag->tag);
            return $lastSequenceNumber + 1;
        } else {
            return 1;
        }
    }
}
