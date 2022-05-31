<?php

use Illuminate\Database\Seeder;
use App\Models\Roles;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [1, 'Superadmin', 1, '2021-06-25 21:34:26', '2021-06-25 21:34:26'],
            [2, 'Admin', 1, '2021-06-26 06:34:26', '2021-06-26 06:34:26'],
            [2, 'User', 1, '2021-06-26 06:34:26', '2021-06-26 06:34:26'],
        ];

        foreach($roles as $key => $row) {
            Roles::create([
                'roles' => $row[1],
                'is_active' => $row[2],
                'created_at' => $row[3],
                'updated_at' => $row[4]
            ]);
        }
    }
}
