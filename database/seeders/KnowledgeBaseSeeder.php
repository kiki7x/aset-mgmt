<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class KnowledgeBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kb_categories')->insert([
            ['id' => 1, 'name' => 'Root', 'slug' => 'root', 'description' => 'root'],
            ['id' => 2, 'name' => 'SOP TIK', 'slug' => 'sop-tik', 'description' => 'SOP TIK'],
            ['id' => 3, 'name' => 'Panduan TIK', 'slug' => 'panduan-tik', 'description' => 'Panduan TIK'],
            ['id' => 4, 'name' => 'SOP RT', 'slug' => 'sop-rt', 'description' => 'SOP RT'],
            ['id' => 5, 'name' => 'Panduan RT', 'slug' => 'panduan-rt', 'description' => 'Panduan RT'],
        ]);
    }
}
