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
            'monitoring-create',
            'monitoring-edit',
            'monitoring-delete',
            'logs-view',
            'reminder-view',
            'laporan-view',
            'setting-atribut-view',
            'setting-atribut-create',
            'setting-atribut-edit',
            'setting-atribut-delete',
            'settings-usermanager-view',
            'settings-usermanager-create',
            'settings-usermanager-edit',
            'settings-usermanager-delete',
            'settings-import-view',
            'settings-import-create',
            'settings-config-view',
            'settings-config-edit',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }
    }
}
