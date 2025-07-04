<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ClassificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assetclassifications')->insert([
            ['id' => 1, 'name' => 'None', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'TIK', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Kendaraan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Mesin/Elektronik', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
