<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIkmSettingsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ikm_score'  => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => '-'],
            'ikm_year'   => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => date('Y')],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ikm_settings', true);

        // Initial default row
        $db = \Config\Database::connect();
        $db->table('ikm_settings')->insert([
            'id'         => 1,
            'ikm_score'  => '-',
            'ikm_year'   => date('Y'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('ikm_settings', true);
    }
}
