<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Shuchkin\SimpleXLSX;

class ImportController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.import.index');
    }

    public function storeAsetRt(Request $request): JsonResponse
    {
        if ($xlsx = SimpleXLSX::parse($request->file('fileasetrt'))) {
            $rows = $xlsx->rows();
            array_shift($rows); // Menghapus baris pertama (header)

            $errors = []; // Tempat menampung log error
            $successCount = 0;

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // Baris dimulai dari 2

                // 1. Validasi kolom kosong
                if (empty($row[0]))
                    $errors[] = "Baris $rowNumber: Kolom 'Tag' tidak boleh kosong.";
                if (empty($row[14]))
                    $errors[] = "Baris $rowNumber: Kolom 'Serial' tidak boleh kosong.";

                // 2. Lookup Relasi (Validasi Dropdown)
                $classification = \App\Models\AssetclassificationsModel::where('name', $row[1])->first();
                $category = \App\Models\AssetcategoriesModel::firstOrCreate(['name' => trim($row[3])], ['classification_id' => $classification->id]);
                $location = \App\Models\LocationsModel::where('name', $row[11])->first();
                $admin = \App\Models\User::where('username', $row[4])->first();
                $client = \App\Models\ClientsModel::where('name', $row[5])->first();
                $user = \App\Models\User::where('username', $row[6])->first();
                $supplier = \App\Models\SuppliersModel::where('name', $row[9])->first();
                $status = \App\Models\LabelsModel::where('name', $row[10])->first();
                $manufacturer = \App\Models\ManufacturersModel::firstOrCreate(['name' => trim($row[7])]);
                $model = \App\Models\ModelsModel::firstOrCreate(['name' => trim($row[8])]);
                $supplier = \App\Models\SuppliersModel::firstOrCreate(['name' => trim($row[9])]);


                if (!$category)
                    $errors[] = "Baris $rowNumber: Kategori '{$row[3]}' tidak terdaftar di sistem.";
                if (!$location)
                    $errors[] = "Baris $rowNumber: Lokasi '{$row[11]}' tidak terdaftar di sistem.";

                // 3. Jika tidak ada error di baris ini, simpan ke Database
                if (empty($errors)) {
                    \App\Models\AssetsModel::updateOrCreate(
                        ['serial' => $row[14]],
                        [
                            'tag' => $row[0],
                            'classification_id' => $classification->id,
                            'name' => $row[2],
                            'category_id' => $category->id,
                            'admin_id' => $admin->id,
                            'client_id' => $client->id,
                            'user_id' => $user->id,
                            'manufacturer_id' => $manufacturer->id,
                            'model_id' => $model->id,
                            'supplier_id' => $supplier->id,
                            'status_id' => $status->id,
                            'location_id' => $location->id,
                            'purchase_date' => $row[12],
                            'warranty_months' => $row[13],
                            'notes' => $row[15],
                        ]
                    );
                    $successCount++;
                }
            }
            // Kirim respon balik
            return response()->json([
                'status' => count($errors) > 0 ? 'partial_error' : 'success',
                'success_count' => $successCount,
                'errors' => $errors //Berisi daftar error spesifik
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mengimport data.'
        ], 400);
    }

    public function storeAsetTik(Request $request): JsonResponse
    {
        if ($xlsx = SimpleXLSX::parse($request->file('fileasettik'))) {
            $rows = $xlsx->rows();
            array_shift($rows); // Menghapus baris pertama (header)

            $errors = []; // Tempat menampung log error
            $successCount = 0;

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // Baris dimulai dari 2

                // 1. Validasi kolom kosong
                if (empty($row[0]))
                    $errors[] = "Baris $rowNumber: Kolom 'Tag' tidak boleh kosong.";
                if (empty($row[14]))
                    $errors[] = "Baris $rowNumber: Kolom 'Serial' tidak boleh kosong.";

                // 2. Lookup Relasi (Validasi Dropdown)
                $classification = \App\Models\AssetclassificationsModel::where('name', $row[1])->first();
                $category = \App\Models\AssetcategoriesModel::firstOrCreate(['name' => trim($row[3])], ['classification_id' => $classification->id]);
                $location = \App\Models\LocationsModel::where('name', $row[11])->first();
                $admin = \App\Models\User::where('username', $row[4])->first();
                $client = \App\Models\ClientsModel::where('name', $row[5])->first();
                $user = \App\Models\User::where('username', $row[6])->first();
                $supplier = \App\Models\SuppliersModel::where('name', $row[9])->first();
                $status = \App\Models\LabelsModel::where('name', $row[10])->first();
                $manufacturer = \App\Models\ManufacturersModel::firstOrCreate(['name' => trim($row[7])]);
                $model = \App\Models\ModelsModel::firstOrCreate(['name' => trim($row[8])]);
                $supplier = \App\Models\SuppliersModel::firstOrCreate(['name' => trim($row[9])]);


                if (!$category)
                    $errors[] = "Baris $rowNumber: Kategori '{$row[3]}' tidak terdaftar di sistem.";
                if (!$location)
                    $errors[] = "Baris $rowNumber: Lokasi '{$row[11]}' tidak terdaftar di sistem.";

                // 3. Jika tidak ada error di baris ini, simpan ke Database
                if (empty($errors)) {
                    \App\Models\AssetsModel::updateOrCreate(
                        ['serial' => $row[14]],
                        [
                            'tag' => $row[0],
                            'classification_id' => $classification->id,
                            'name' => $row[2],
                            'category_id' => $category->id,
                            'admin_id' => $admin->id,
                            'client_id' => $client->id,
                            'user_id' => $user->id,
                            'manufacturer_id' => $manufacturer->id,
                            'model_id' => $model->id,
                            'supplier_id' => $supplier->id,
                            'status_id' => $status->id,
                            'location_id' => $location->id,
                            'purchase_date' => $row[12],
                            'warranty_months' => $row[13],
                            'notes' => $row[15],
                        ]
                    );
                    $successCount++;
                }
            }
            // Kirim respon balik
            return response()->json([
                'status' => count($errors) > 0 ? 'partial_error' : 'success',
                'success_count' => $successCount,
                'errors' => $errors //Berisi daftar error spesifik
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mengimport data.'
        ], 400);
    }

    public function storeLokasi(Request $request): JsonResponse
    {
        $request->validate([
            'filelokasi' => 'required|mimes:xlsx',
        ]);

        if ($xlsx = SimpleXLSX::parse($request->file('filelokasi'))) {
            $rows = $xlsx->rows();
            array_shift($rows); // Menghapus baris pertama (header)

            foreach ($rows as $row) {
                // logika pencarian building_id
                $building_id = \App\Models\BuildingsModel::where('name', $row[0])->first();
                // logika batalkan jika building tidak ditemukan
                if (!$building_id) {
                    return response()->json(['message' => 'Building ' . $row[0] . ' tidak ditemukan.']);
                } else {
                    \App\Models\LocationsModel::create([
                        'building_id' => $building_id->id,
                        'name' => $row[1],
                        'floor' => $row[2],
                    ]);
                }
            }
            return response()->json(['status' => 'success', 'message' => 'Data lokasi berhasil diimport.']);
        }
        return response()->json(['status' => 'error', 'message' => 'Gagal mengimport data.']);
    }
}
