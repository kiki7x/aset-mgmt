<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
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
use App\Notifications\DeleteAsetRT;
use App\Notifications\DeleteAsetTik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AssetController extends Controller
{
    public $prefix_tik = "tik";
    public $prefix_rt = "rt";
    public $classification_tik_id = "2";
    public $classification_rt_id = "3";
    public $client_id = 1;

    public function index_tik()
    {
        $manufacturers = ManufacturersModel::get();
        $models = ModelsModel::get();
        $suppliers = SuppliersModel::get();
        $locations = LocationsModel::get();
        $statuses = LabelsModel::get();
        $users = User::get();
        $categories = AssetcategoriesModel::whereIn('classification_id', [2])->get();
        $totalAssets = AssetsModel::where('classification_id', 2)->count();

        return view('admin.asettik.index', compact('totalAssets', 'categories', 'manufacturers', 'models', 'suppliers', 'locations', 'statuses', 'users'));
    }

    public function index_rt()
    {
        $manufacturers = ManufacturersModel::get();
        $models = ModelsModel::get();
        $suppliers = SuppliersModel::get();
        $locations = LocationsModel::get();
        $statuses = LabelsModel::get();
        $users = User::get();

        $categories = AssetcategoriesModel::whereIn('classification_id', [3, 4])->get();

        $assets = AssetsModel::with('category', 'status', 'model', 'user')->where('classification_id', 2)->latest()->paginate(10);

        $totalAssets = AssetsModel::where('classification_id', 3)->count();

        return view('admin.asetrt.index', compact('assets', 'totalAssets', 'categories', 'manufacturers', 'models', 'suppliers', 'locations', 'statuses', 'users'));
    }

    public function get_assets(Request $request)
    {
        $category = $request->category;
        $classification = $request->classification;

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
            ->addColumn('name', function ($asset) {
                return '
                <a href="' . route('admin.asetrt.show', $asset->id) . '" class="font-weight-bold">' . e($asset->name) . '</a><br>
                <span class="text-muted">Serial No: </span>' . e($asset->serial) . '<br>
                <span class="text-muted">Status: </span>
                <span class="badge" style="background-color: ' . e($asset->status->color ?? '#999') . '; color: white;">' . e($asset->status->name ?? '-') . '</span>
            ';
            })
            ->addColumn('tag', function ($asset) {
                return '<a href="' . route('admin.asetrt.show', $asset->id) . '">' . e($asset->tag) . '</a>';
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
            ->addColumn('updated_at', function ($asset) {
                return $asset->updated_at->format('Y-m-d');
            })
            ->addColumn('action', function ($asset) use ($classification) {
                if ($classification === "tik") {
                    $routeEdit = "asettik";
                }

                if ($classification === "rt") {
                    $routeEdit = "asetrt";
                }
                return '
                <div class="btn-group">
                    <a href="' . route('admin.asetrt.pemeliharaan', ['id' => $asset->id]) . '" class="btn btn-light">
                        <i class="fa-regular fa-calendar-check" style="color: green" title="Jadwal Pemeliharaan"></i>
                    </a>
                    <span class="btn btn-light" style="color: blue" data-toggle="modal" data-target="#qrCodeModal" data-tag="' . $asset->tag . '" data-name="' . e($asset->name) . '">
                        <i class="fas fa-qrcode"></i>
                    </span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a class="mx-3" href="' . route("admin.$routeEdit.edit", ['id' => $asset->id]) . '">Edit</a></li>
                            <li><span class="mx-3" data-toggle="modal" data-target="#deleteModal" data-id="' . $asset->id . '" data-name="' . e($asset->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                </div>
            ';
            })
            ->rawColumns(['tag', 'name', 'category', 'action'])
            ->make(true);
    }

    public function store(StoreAssetRequest $request, $classification)
    {
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

        $admin_id = auth()->user()->id;

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
            'classification_id' => (int) $classification_id,
            'category_id' => (int) $request->category_id,
            'admin_id' => (int) $admin_id,
            'client_id' => (int) $this->client_id,
            'user_id' => (int) $request->user_id,
            'manufacturer_id' => (int) $request->manufacturer_id,
            'model_id' => (int) $request->model_id,
            'supplier_id' => (int) $request->supplier_id,
            'status_id' => (int) $request->status_id,
            'purchase_date' => Carbon::parse($request->purchase_date)->format('Y-m-d'),
            'warranty_months' => (int) $request->warranty_months,
            'tag' => $newTag,
            'name' => $request->name,
            'serial' => $request->serial,
            'notes' => $request->notes,
            'location_id' => (int) $request->location_id,
            'customfields' => $request->customfields,
            'qrvalue' => $request->qrvalue,
        ];

        $aset = AssetsModel::Create($data);

        // kirim notifikasi
        $users = User::whereHas('roles', function ($query) use ($sendNotificationByRole) {
            $query->whereIn('name', $sendNotificationByRole);
        })->get();

        foreach ($users as $user) {
            $user->notify(new $notificationClass($aset));
        }
    }

    public function update(Request $request, $id)
    {
        //
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

    public function show($id)
    {
        //
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
