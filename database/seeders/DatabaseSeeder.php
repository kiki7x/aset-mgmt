<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            ClassificationsSeeder::class,
            CategoriesSeeder::class,
            ClientsSeeder::class,
            LabelsSeeder::class,
            LicensecategoriesSeeder::class,
            LocationsSeeder::class,
            ManufacturersSeeder::class,
            ModelsSeeder::class,
            SuppliersSeeder::class,
            AssetsRTSeeder::class,
            AssetsTIKSeeder::class,
            // ImportSeeder::class
        ]);

    }
}
