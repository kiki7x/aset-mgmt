<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assetcategories')->insert([
            ['id' => 1, 'name' => 'None', 'color' => '#000000', 'classification_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Desktop PC', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Laptop', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Server', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Printer', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Router', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Switch Managed', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Switch Unmanaged', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'AIO PC', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Monitor', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Televisi', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Projector', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'NVR (Network Video Recorder)', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'IP Camera', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Wireless Access Point', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'Kendaraan Roda 2', 'color' => '#007bff', 'classification_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'Kendaraan Roda 4', 'color' => '#007bff', 'classification_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'Video Switcher', 'color' => '#007bff', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Bus Besar', 'color' => '#007bff', 'classification_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'Genset', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'AC', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'Peralatan Dapur', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'Mesin Laundry', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'Sound System', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'name' => 'Tablet', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'name' => 'UPS', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'name' => 'Scanner', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'name' => 'Peripheral PC', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'name' => 'Modem', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'name' => 'Coffee Maker', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'name' => 'Finger Print', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'name' => 'Kamera', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'name' => 'Handphone', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'name' => 'Handy Talky', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'name' => 'Stavolt', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'name' => 'Peralatan Sanitasi', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'name' => 'Peralatan Housekeeping', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'name' => 'Pendingin', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 39, 'name' => 'Gas', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 40, 'name' => 'Layar Proyektor', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 41, 'name' => 'Lensa Kamera', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 42, 'name' => 'Software', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 43, 'name' => 'Kompor', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 44, 'name' => 'Pompa Air', 'color' => '#007bff', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 45, 'name' => 'PABX', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 46, 'name' => 'Telephone PABX', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 47, 'name' => 'Telephone Mobile', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 48, 'name' => 'Video Wall', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 49, 'name' => 'Smart Board', 'color' => '#28a745', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
