<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLSXGen;

class ImportController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->user()->can('settings-import-view'), 403);
        return view('admin.settings.import.index');
    }

    public function storeAsetRt(Request $request): JsonResponse
    {
        abort_unless(auth()->user()->can('settings-import-create'), 403);
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
        abort_unless(auth()->user()->can('settings-import-create'), 403);
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
        abort_unless(auth()->user()->can('settings-import-create'), 403);
        $request->validate([
            'filelokasi' => 'required|mimes:xlsx',
        ]);

        if ($xlsx = SimpleXLSX::parse($request->file('filelokasi'))) {
            $rows = $xlsx->rows();
            array_shift($rows); // Menghapus baris pertama (header)

            $errors = []; // Tempat menampung log error
            $successCount = 0;

            foreach ($rows as $row) {
                // logika pencarian building_id
                $building_id = \App\Models\BuildingsModel::where('name', $row[0])->first();
                // logika batalkan jika building tidak ditemukan
                if (!$building_id) {
                    $errors[] = "Baris " . $row[0] . ": Building tidak ditemukan.";
                } else {
                    \App\Models\LocationsModel::create([
                        'building_id' => $building_id->id,
                        'name' => $row[1],
                        'floor' => $row[2],
                    ]);
                    $successCount++;
                }
            }
            return response()->json([
                'status' => 'success',
                'success_count' => $successCount,
                'errors' => $errors,
                'message' => 'Data lokasi berhasil diimport.'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mengimport data.'
        ], 400);
    }

    public function templateUser()
    {
        $data = [
            ['fullname', 'username', 'email', 'password'],
            ['Budi Santoso', 'budi.santoso', 'budi@example.com', 'password123'],
        ];

        $date = now()->format('d-m-Y');

        return SimpleXLSXGen::fromArray($data)->downloadAs("{$date}_sapa-ppl-user-management-template.xlsx");
    }

    public function storeUserManagement(Request $request): JsonResponse
    {
        abort_unless(auth()->user()->can('settings-import-create'), 403);
        try {
            // Increase execution time untuk import (bcrypt banyak password bisa timeout)
            set_time_limit(300); // 5 menit untuk batch import
            
            // === STEP 1: Validasi Request ===
            $validated = $request->validate([
                'fileusermanagement' => 'required|mimes:xlsx',
            ]);

            // === STEP 2: Validasi File ===
            $file = $request->file('fileusermanagement');

            if (!$file || !$file->isValid()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File upload gagal. Cek ukuran file atau koneksi Anda.'
                ], 400);
            }

            // Cek ukuran file (max 2MB)
            $maxSizeBytes = 2 * 1024 * 1024; // 2MB
            if ($file->getSize() > $maxSizeBytes) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ukuran file terlalu besar. Maksimal: 2MB. File Anda: ' . round($file->getSize() / 1024 / 1024, 2) . 'MB'
                ], 400);
            }

            // Cek apakah file readable
            $filePath = $file->getRealPath();
            if (!is_readable($filePath)) {
                Log::error('Import user: File tidak readable', ['path' => $filePath]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'File tidak dapat dibaca. Coba upload file yang lain.'
                ], 400);
            }

            // === STEP 3: Parse File XLSX ===
            try {
                $xlsx = SimpleXLSX::parse($filePath);
            } catch (\Exception $e) {
                Log::error('Import user: SimpleXLSX parse error', ['error' => $e->getMessage()]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'File Excel tidak valid atau rusak. Error: ' . $e->getMessage()
                ], 400);
            }

            // Jika SimpleXLSX return null/false
            if (!$xlsx) {
                Log::error('Import user: SimpleXLSX returned null', ['file' => $file->getClientOriginalName()]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'File Excel tidak dapat diparsing. Pastikan:
                        1. File dalam format .xlsx (bukan .xls atau .csv)
                        2. File tidak corrupted/rusak
                        3. Download template terlebih dahulu dan isi sesuai format'
                ], 400);
            }

            $rows = $xlsx->rows();

            // === STEP 4: Validasi Struktur File ===
            if (empty($rows)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File kosong. Minimal harus ada header dan 1 data user.'
                ], 400);
            }

            // Validasi header
            $headerRow = $rows[0];
            $expectedHeaders = ['fullname', 'username', 'email', 'password'];

            if (count($headerRow) < 4) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File Excel tidak sesuai format. Kolom minimal: 4 (fullname, username, email, password). File Anda: ' . count($headerRow) . ' kolom.'
                ], 400);
            }

            // Cek header match
            $headerMismatch = [];
            for ($i = 0; $i < 4; $i++) {
                if (strtolower(trim($headerRow[$i] ?? '')) !== $expectedHeaders[$i]) {
                    $headerMismatch[] = "Kolom " . ($i + 1) . ": expected '{$expectedHeaders[$i]}', got '" . ($headerRow[$i] ?? 'kosong') . "'";
                }
            }

            if (!empty($headerMismatch)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Header file tidak sesuai template. ' . implode(', ', $headerMismatch) . '. Download template terlebih dahulu.'
                ], 400);
            }

            array_shift($rows); // Remove header row

            // === STEP 5: Cek Role User ===
            $role = Role::where('name', 'user')->first();
            if (!$role) {
                Log::error('Import user: Role user tidak ditemukan');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role "user" tidak ditemukan di sistem. Hubungi administrator.'
                ], 404);
            }

            // === STEP 6: Ambil Daftar Username & Email yang Sudah Ada ===
            try {
                $knownUsernames = array_fill_keys(
                    \App\Models\User::query()->pluck('username')->filter()->all(),
                    true
                );
                $knownEmails = array_fill_keys(
                    \App\Models\User::query()->pluck('email')->filter()->all(),
                    true
                );
            } catch (\Exception $e) {
                Log::error('Import user: Error query existing users', ['error' => $e->getMessage()]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal query data existing user. Error: ' . $e->getMessage()
                ], 500);
            }

            $errors = [];
            $pendingUsers = [];
            $successCount = 0;
            $timestamp = now();
            
            // Reduce BCRYPT_ROUNDS untuk import agar tidak timeout
            config(['hashing.bcrypt.rounds' => 4]);

            // === STEP 7: Validasi & Proses Setiap Row ===
            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // Baris dimulai dari 2 (setelah header)
                $rowErrors = [];

                // Cek minimal kolom yang ada
                if (count($row) < 4) {
                    $errors[] = "Baris $rowNumber: Jumlah kolom tidak lengkap. Expected: 4 kolom, Got: " . count($row) . " kolom.";
                    continue;
                }

                $fullname = trim((string) ($row[0] ?? ''));
                $usernameInput = trim((string) ($row[1] ?? ''));
                $email = trim((string) ($row[2] ?? ''));
                $password = trim((string) ($row[3] ?? ''));

                // Validasi kolom tidak kosong
                if ($fullname === '') {
                    $rowErrors[] = "Kolom 'fullname' tidak boleh kosong.";
                }
                if ($email === '') {
                    $rowErrors[] = "Kolom 'email' tidak boleh kosong.";
                }
                if ($password === '') {
                    $rowErrors[] = "Kolom 'password' tidak boleh kosong.";
                }

                // Jika username tidak ada, gunakan fullname
                if ($usernameInput === '' && $fullname === '') {
                    $rowErrors[] = "Minimal 'fullname' atau 'username' harus diisi.";
                }

                // Validasi format email
                if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $rowErrors[] = "Format email tidak valid: '{$email}'.";
                }

                // Validasi panjang password (bcrypt max 72 char)
                if ($password !== '' && strlen($password) > 72) {
                    $rowErrors[] = "Password terlalu panjang. Maksimal: 72 karakter. Password Anda: " . strlen($password) . " karakter.";
                }

                // Cek duplicate dalam batch
                if ($email !== '' && isset($knownEmails[$email])) {
                    $rowErrors[] = "Email '{$email}' sudah digunakan di sistem.";
                }

                if (!empty($rowErrors)) {
                    foreach ($rowErrors as $message) {
                        $errors[] = "Baris $rowNumber: {$message}";
                    }
                    continue;
                }

                // Generate username
                $username = $this->normalizeImportedUsername($fullname, $usernameInput, $knownUsernames);

                $pendingUsers[] = [
                    'fullname' => $fullname,
                    'username' => $username,
                    'email' => $email,
                    'password' => Hash::make($password), // Use Hash::make() to respect bcrypt.rounds config
                    'avatar' => null,
                    'email_verified_at' => null,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];

                $knownUsernames[$username] = true;
                $knownEmails[$email] = true;
            }

            // === STEP 8: Cek apakah ada data yang valid ===
            if (empty($pendingUsers) && !empty($errors)) {
                return response()->json([
                    'status' => 'error',
                    'success_count' => 0,
                    'errors' => $errors,
                    'message' => 'Tidak ada data yang valid untuk diimport.'
                ], 400);
            }

            // === STEP 9: Simpan ke Database (Transaction) ===
            if (!empty($pendingUsers)) {
                try {
                    DB::transaction(function () use ($pendingUsers, $role, &$successCount) {
                        // Insert users
                        \App\Models\User::insert($pendingUsers);

                        // Get inserted users
                        $insertedUsers = \App\Models\User::query()
                            ->whereIn('email', array_column($pendingUsers, 'email'))
                            ->get(['id', 'email']);

                        // Assign role to users
                        $pivotRows = [];
                        foreach ($insertedUsers as $user) {
                            $pivotRows[] = [
                                'role_id' => $role->id,
                                'model_type' => \App\Models\User::class,
                                'model_id' => $user->id,
                            ];
                        }

                        if (!empty($pivotRows)) {
                            DB::table('model_has_roles')->insert($pivotRows);
                        }

                        $successCount = count($pendingUsers);
                    });

                    Log::info('Import user: Success', ['count' => $successCount, 'errors' => count($errors)]);

                } catch (\Illuminate\Database\QueryException $e) {
                    Log::error('Import user: Database error', [
                        'error' => $e->getMessage(),
                        'sql' => $e->getSql() ?? 'N/A'
                    ]);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Gagal menyimpan ke database. Error: ' . $e->getMessage()
                    ], 500);
                } catch (\Exception $e) {
                    Log::error('Import user: Unexpected error during save', ['error' => $e->getMessage()]);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Terjadi error tidak terduga. Error: ' . $e->getMessage()
                    ], 500);
                }
            } else {
                $successCount = 0;
            }

            // === STEP 10: Kirim Response ===
            return response()->json([
                'status' => count($errors) > 0 ? 'partial_error' : 'success',
                'success_count' => $successCount,
                'errors' => $errors,
                'message' => 'Import selesai. ' . $successCount . ' user berhasil dibuat.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Import user: Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid: ' . implode(', ', array_map(fn($msgs) => implode(', ', $msgs), $e->errors()))
            ], 422);
        } catch (\Exception $e) {
            Log::error('Import user: Unexpected error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi error tidak terduga: ' . $e->getMessage()
            ], 500);

        }
    }

    private function normalizeImportedUsername(string $fullname, string $usernameInput, array &$knownUsernames): string
    {
        $base = Str::slug($usernameInput !== '' ? $usernameInput : $fullname, '.');
        $base = str_replace('.', '_', $base);
        $base = strtolower(trim($base, '-_'));

        if ($base === '') {
            $base = 'user';
        }

        $maxLength = 20;
        $candidate = substr($base, 0, $maxLength);
        $candidate = rtrim($candidate, '-_');

        if ($candidate === '') {
            $candidate = 'user';
        }

        $suffix = 1;
        while (isset($knownUsernames[$candidate])) {
            $suffixText = '-' . $suffix;
            $candidate = substr($base, 0, $maxLength - strlen($suffixText));
            $candidate = rtrim($candidate, '-_');
            $candidate .= $suffixText;
            $suffix++;
        }

        return $candidate;
    }
}
