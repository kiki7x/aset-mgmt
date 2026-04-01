<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('buildings')->insert([
            ['id' => 1, 'client_id' => 1,'name' => 'None', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'client_id' => 1,'name' => 'Rektorat', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'client_id' => 1,'name' => 'Gedung Kuliah 1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'client_id' => 1,'name' => 'Gedung Kuliah 2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'client_id' => 1,'name' => 'Hotel DBSH', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'client_id' => 1,'name' => 'Masjid Al-Hanif', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'client_id' => 1,'name' => 'GKT Rinjani', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'client_id' => 1,'name' => 'Kantin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'client_id' => 1,'name' => 'Gedung Hospitality', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'client_id' => 1,'name' => 'Dapur Praktik Kontinental', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'client_id' => 1,'name' => 'Restaurant Oriental', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'client_id' => 1,'name' => 'MDK MKP', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'client_id' => 1,'name' => 'Restaurant Nusantara', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'client_id' => 1,'name' => 'Dapur Praktik Oriental', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'client_id' => 1,'name' => 'Restaurant Hotel Praktik', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'client_id' => 1,'name' => 'Hall TAH', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'client_id' => 1,'name' => 'Gudang Dapur', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'client_id' => 1,'name' => 'Kitchen Stadium', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('locations')->insert([
            // None
            ['building_id' => 1, 'name' => 'None', 'floor' => 'None', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
