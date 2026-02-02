<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\AssetsModel;
use App\Models\ModelsModel;

class AssetsTIKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('assets')->insert([
        // ]);
        // AssetsModel::truncate(); // jangan di truncate kalau mau nambah data tanpa hapus data lama
        // 1. Seed the Models table with unique model names from the CSV
        $csvFile = fopen(base_path("database/import-tik.csv"), "r");
        $firstline = true;
        $modelNames = []; // Array to store unique model names

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                $modelNames[] = $data[8]; // Assuming model name is in the 9th column (index 8)
            }
            $firstline = false;
        }
        fclose($csvFile);

        // Remove duplicate model names and insert them into the Models table
        $uniqueModelNames = array_unique($modelNames);
        foreach ($uniqueModelNames as $modelName) {
            // Check if the model name already exists to avoid duplicates
            $existingModel = ModelsModel::where('name', $modelName)->first();
            if (!$existingModel) {
                ModelsModel::create(['name' => $modelName]);
            }
        }


        // 2. Now, read the CSV again and insert into Assets, using the correct model IDs
        $csvFile = fopen(base_path("database/import-tik.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                $modelName = $data[8];
                $model = ModelsModel::where('name', $modelName)->first();
                if ($model) {
                    $modelID = $model->id;
                AssetsModel::create([
                    'tag' => $data[0],
                    'classification_id' => $data[1],
                    'name' => $data[2],
                    'category_id' => $data[3],
                    'admin_id' => $data[4],
                    'client_id' => $data[5],
                    'user_id' => $data[6],
                    'manufacturer_id' => $data[7],
                    'model_id' => $modelID,
                    'supplier_id' => $data[9],
                    'status_id' => $data[10],
                    'location_id' => $data[11],
                    'purchase_date' => $data[12],
                    'warranty_months' => $data[13],
                    'serial' => $data[14],
                ]);
            }}else{
                \Log::error("Model not found: " . $modelName);
            }
        $firstline = false;
    }
    fclose($csvFile);
    }
}
