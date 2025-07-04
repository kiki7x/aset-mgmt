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
            ['id' => 1, 'name' => 'None', 'color' => '#ff0000', 'classification_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Desktop PC', 'color' => '#1e3fda', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Laptops', 'color' => '#058e29', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Servers', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Printers', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Routers', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Switch Managed', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Switch Unmanaged', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'AIO PC', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Monitors', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'TV', 'color' => '#ff0000', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Projectors', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'NVR (Network Video Recorder)', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'IP Cameras', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Wireless Access Points', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'Kendaraan Roda 2', 'color' => '#ff0000', 'classification_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'Kendaraan Roda 4', 'color' => '#ff0000', 'classification_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'Mini Bus', 'color' => '#ff0000', 'classification_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Bus Besar', 'color' => '#ff0000', 'classification_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'Genset', 'color' => '#ff0000', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'AC', 'color' => '#ff0000', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'Peralatan Dapur', 'color' => '#ff0000', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'Mesin Laundry', 'color' => '#ff0000', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'Sound System', 'color' => '#ff0000', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'name' => 'Tablet', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'name' => 'UPS', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'name' => 'Scanner', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'name' => 'Peripheral PC', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'name' => 'Modem', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'name' => 'Coffee Maker', 'color' => '#ff0000', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'name' => 'Finger Print', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'name' => 'Kamera', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'name' => 'Handphone', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'name' => 'Handy Talky', 'color' => '#ff0000', 'classification_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'name' => 'Stavolt', 'color' => '#ff0000', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'name' => 'Peralatan Sanitasi', 'color' => '#ff0000', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'name' => 'Peralatan Housekeeping', 'color' => '#ff0000', 'classification_id' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
