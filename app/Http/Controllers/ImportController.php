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

            foreach ($rows as $row) {

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
            return response()->json(['message' => 'Data lokasi berhasil diimport.']);
        }
        return response()->json(['message' => 'Gagal mengimport data.']);
    }
}
