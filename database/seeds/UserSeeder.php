<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [1, 'superadmin@local.com', 'superadmin', 'Super Administrator', '$2y$10$ao/iDtHHpF.aFrCkOZz5n.F52sjQqtGMVWfrkU2bFGxNhipH8tr.K', 1, '2021-06-25 21:34:26', '2021-06-25 21:34:26'],
            // [2, 'admin@local.com', 'admin', 'Administrator', '$2y$10$ao/iDtHHpF.aFrCkOZz5n.F52sjQqtGMVWfrkU2bFGxNhipH8tr.K', 1, '2021-06-25 21:34:26', '2021-06-25 21:34:26'],
        ];

        foreach($user as $key => $row) {
            User::create([
                'role_id' => $row[0],
                'email' => $row[1],
                'username' => $row[2],
                'name' => $row[3],
                'password' => $row[4],
                'is_active' => $row[5],
                'created_at' => $row[6],
                'updated_at' => $row[7]
            ]);
        }
    }
}
