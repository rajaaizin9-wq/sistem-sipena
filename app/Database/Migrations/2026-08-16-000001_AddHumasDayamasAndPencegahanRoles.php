<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Humas;

class AddHumasDayamasAndPencegahanRoles extends Migration
{
    public function up(): void
    {
        $this->forge->modifyColumn('users', [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => Humas::ROLES,
            ],
        ]);
    }

    public function down(): void
    {
        $this->db->table('users')->whereIn('role', ['humas_dayamas', 'humas_pencegahan'])->delete();
        $this->forge->modifyColumn('users', [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => array_slice(Humas::ROLES, 0, 2),
            ],
        ]);
    }
}
