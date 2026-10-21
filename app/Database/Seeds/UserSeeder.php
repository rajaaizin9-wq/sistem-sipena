<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name'       => 'Humas Umum',
                'username'   => 'humas_umum',
                'email'      => 'humas.umum@bnn.local',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'humas_umum',
                'is_active'  => 1,
                'last_login' => null,
            ],
            [
                'name'       => 'Humas Rehabilitasi',
                'username'   => 'humas_rehabilitasi',
                'email'      => 'humas.rehabilitasi@bnn.local',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'humas_rehabilitasi',
                'is_active'  => 1,
                'last_login' => null,
            ],
            [
                'name'       => 'Humas Dayamas',
                'username'   => 'humas_dayamas',
                'email'      => 'humas.dayamas@bnn.local',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'humas_dayamas',
                'is_active'  => 1,
                'last_login' => null,
            ],
            [
                'name'       => 'Humas Pencegahan',
                'username'   => 'humas_pencegahan',
                'email'      => 'humas.pencegahan@bnn.local',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'humas_pencegahan',
                'is_active'  => 1,
                'last_login' => null,
            ],
        ];

        $this->db->table('users')->insertBatch($users);
    }
}
