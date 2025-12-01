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
            ['id' => 8, 'client_id' => 1,'name' => 'Zona B Praktikum', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'client_id' => 1,'name' => 'Kantin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'client_id' => 1,'name' => 'Gedung Hospitality', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('locations')->insert([
            ['id' => 1, 'building_id' => 1, 'name' => 'None', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'building_id' => 2, 'name' => 'Rektorat loc', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'building_id' => 3, 'name' => 'Gedung Kuliah 1 loc', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'building_id' => 4, 'name' => 'Gedung Kuliah 2 loc', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'building_id' => 5, 'name' => 'Hotel DBSH loc', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'building_id' => 6, 'name' => 'Masjid Al-Hanif loc', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'building_id' => 7, 'name' => 'GKT Rinjani loc', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'building_id' => 8, 'name' => 'Zona B Praktikum loc', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'building_id' => 9, 'name' => 'Kantin loc', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'building_id' => 10, 'name' => 'Gedung Hospitality loc', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
