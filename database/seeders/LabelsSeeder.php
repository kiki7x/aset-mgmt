<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LabelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('labels')->insert([
            ['id' => 1, 'name' => 'None', 'color' => '#000000', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Digunakan', 'color' => '#28a745', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Rusak', 'color' => '#dc3545', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Dalam Perbaikan', 'color' => '#fd7e14', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Diarsipkan', 'color' => '#6c757d', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Dipinjam', 'color' => '#ffc107', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
