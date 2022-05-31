<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [1, 'menu-dashboard-show', 'Permission to show dashboard menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [2, 'section-admin-show', 'Permission to show admin section', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [3, 'menu-settings-show', 'Permission to show settings menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [4, 'menu-usermanagement-show', 'Permission to show usermanagement menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [5, 'menu-usermanagement-create', 'Permission to create in usermanagement menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [6, 'menu-usermanagement-edit', 'Permission to edit in usermanagement menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [7, 'menu-usermanagement-delete', 'Permission to delete in usermanagement menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [8, 'menu-section-show', 'Permission to show section menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [9, 'menu-section-create', 'Permission to create in section menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [10, 'menu-section-edit', 'Permission to edit in section menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [11, 'menu-section-delete', 'Permission to delete in section menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [12, 'menu-menu-show', 'Permission to show menu menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [13, 'menu-menu-create', 'Permission to create in menu menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [14, 'menu-menu-edit', 'Permission to edit in menu menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [15, 'menu-menu-delete', 'Permission to delete in menu menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [16, 'menu-roles-show', 'Permission to show roles menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [17, 'menu-roles-create', 'Permission to create in roles menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [18, 'menu-roles-edit', 'Permission to edit in roles menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
            [19, 'menu-roles-delete', 'Permission to delete in roles menu', 1, '2021-08-16 09:51:00', '2021-08-16 09:51:00'],
        ];

        foreach($permissions as $key => $row) {
            Permission::create([
                'permission_name' => $row[1],
                'description' => $row[2],
                'is_active' => $row[3],
                'created_at' => $row[4],
                'updated_at' => $row[5]
            ]);
        }
    }
}
