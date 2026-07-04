<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleHasPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superadmin = Role::findOrCreate('superadmin');
        $permissions = Permission::all();
        $superadmin->givePermissionTo($permissions);

        $admin_tik = Role::findOrCreate('admin_tik');
        $admin_tik->givePermissionTo([
            'aset-tik-view', 'aset-tik-create', 'aset-tik-edit', 'aset-tik-delete',
            'aset-rt-view',
            'lisensi-view', 'lisensi-create', 'lisensi-edit', 'lisensi-delete',
            'pemeliharaan-view', 'pemeliharaan-create', 'pemeliharaan-edit', 'pemeliharaan-delete',
            'tiket-view', 'tiket-create', 'tiket-edit', 'tiket-delete',
            'knowledge-base-view', 'knowledge-base-create', 'knowledge-base-edit', 'knowledge-base-delete',
            'monitoring-view',
            'laporan-view',
            'settings-view', 'settings-usermanager-create', 'settings-usermanager-edit', 'settings-usermanager-delete', 'settings-import',
        ]);

        $admin_rt = Role::findOrCreate('admin_rt');
        $admin_rt->givePermissionTo([
            'aset-tik-view',
            'aset-rt-view', 'aset-rt-create', 'aset-rt-edit', 'aset-rt-delete',
            'pemeliharaan-view', 'pemeliharaan-create', 'pemeliharaan-edit', 'pemeliharaan-delete',
            'tiket-view', 'tiket-create', 'tiket-edit', 'tiket-delete',
            'knowledge-base-view', 'knowledge-base-create', 'knowledge-base-edit', 'knowledge-base-delete',
            'monitoring-view',
            'laporan-view',
        ]);

        $staf_tik = Role::findOrCreate('staf_tik');
        $staf_tik->givePermissionTo([
            'aset-tik-view', 'aset-tik-create', 'aset-tik-edit',
            'aset-rt-view',
            'lisensi-view', 'lisensi-create', 'lisensi-edit',
            'pemeliharaan-view', 'pemeliharaan-create', 'pemeliharaan-edit',
            'tiket-view', 'tiket-create',
            'knowledge-base-view', 'knowledge-base-create', 'knowledge-base-edit',
        ]);

        $staf_engineering = Role::findOrCreate('staf_engineering');
        $staf_engineering->givePermissionTo([
            'aset-tik-view',
            'aset-rt-view', 'aset-rt-create', 'aset-rt-edit',
            'pemeliharaan-view', 'pemeliharaan-create', 'pemeliharaan-edit',
            'tiket-view', 'tiket-create',
        ]);

        $staf_driver = Role::findOrCreate('staf_driver');
        $staf_driver->givePermissionTo([
            'aset-tik-view',
            'aset-rt-view', 'aset-rt-create', 'aset-rt-edit',
            'pemeliharaan-view', 'pemeliharaan-create', 'pemeliharaan-edit',
            'tiket-view', 'tiket-create',
        ]);

        $user = Role::findOrCreate('user');
        $user->givePermissionTo([
            'aset-tik-view',
            'aset-rt-view',
            'pemeliharaan-view',
            'tiket-view', 'tiket-create',
            'laporan-view',
        ]);
    }
}
