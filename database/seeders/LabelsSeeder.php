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
            ['id' => 1, 'name' => 'None', 'color' => '#ff0000', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Digunakan', 'color' => '#3479da', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Rusak', 'color' => '#776e6e', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Dalam Perbaikan', 'color' => '#da2727', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Diarsipkan', 'color' => '#959d1c', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Dipinjam', 'color' => '#a79d37', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
