<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'aset-tik-view',
            'aset-tik-create',
            'aset-tik-edit',
            'aset-tik-delete',
            'aset-rt-view',
            'aset-rt-create',
            'aset-rt-edit',
            'aset-rt-delete',
            'lisensi-view',
            'lisensi-create',
            'lisensi-edit',
            'lisensi-delete',
            'pemeliharaan-view',
            'pemeliharaan-create',
            'pemeliharaan-edit',
            'pemeliharaan-delete',
            'tiket-view',
            'tiket-create',
            'tiket-edit',
            'tiket-delete',
            'knowledge-base-view',
            'knowledge-base-create',
            'knowledge-base-edit',
            'knowledge-base-delete',
            'monitoring-view',
            'laporan-view',
            'settings-view',
            'settings-usermanager-create',
            'settings-usermanager-edit',
            'settings-usermanager-delete',
            'settings-import',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
