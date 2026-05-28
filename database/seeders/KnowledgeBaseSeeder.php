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
            'id' => 1,
            'name' => 'ROOT', 
            'slug' => 'root',
            'description' => 'ROOT',
        ]);
    }
}
