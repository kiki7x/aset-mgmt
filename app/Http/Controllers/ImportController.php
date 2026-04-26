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
                if (empty($row[0])) $errors[] = "Baris $rowNumber: Kolom 'Tag' tidak boleh kosong.";
                if (empty($row[1])) $errors[] = "Baris $rowNumber: Kolom 'Serial' tidak boleh kosong.";

                // 2. Lookup Relasi (Validasi Dropdown)
                $category = \App\Models\Category::where('name', $row[3])->first();
                $location = \App\Models\Location::where('name', $row[4])->first();

                if (!$category) $errors[] = "Baris $rowNumber: Kategori '{$row[3]}' tidak terdaftar di sistem.";
                if (!$location) $errors[] = "Baris $rowNumber: Lokasi '{$row[4]}' tidak terdaftar di sistem.";

                // 3. Jika tidak ada error di baris ini, simpan ke Database
                if (empty($errors)) {
                    \App\Models\Asset::updateOrCreate(
                        ['serial' => $row[1]],
                        [
                            'tag'         => $row[0],
                            'name'        => $row[2],
                            'category_id' => $category->id,
                            'location_id' => $location->id,
                        ]
                    );
                    $successCount++;
            }
            return response()->json(['message' => 'Data aset tik berhasil diimport.']);
        }
        return response()->json(['message' => 'Gagal mengimport data.']);
    }

    public function storeAsetRt(Request $request): JsonResponse
    {
        //
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
            return response()->json(['status' => 'success','message' => 'Data lokasi berhasil diimport.']);
        }
        return response()->json(['status' => 'error', 'message' => 'Gagal mengimport data.']);
    }
}
