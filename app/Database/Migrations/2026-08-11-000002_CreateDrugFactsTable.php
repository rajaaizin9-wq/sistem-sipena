<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDrugFactsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 100],
            'value' => ['type' => 'VARCHAR', 'constraint' => 30],
            'description' => ['type' => 'VARCHAR', 'constraint' => 150],
            'sort_order' => ['type' => 'TINYINT', 'constraint' => 3, 'unsigned' => true, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('drug_facts', true);
        $this->db->table('drug_facts')->insertBatch([
            ['title' => 'Kasus tahun ini', 'value' => '289', 'description' => 'Kasus tahun ini', 'sort_order' => 1],
            ['title' => 'Penyalahgunaan', 'value' => '1.200', 'description' => 'Penyalahgunaan', 'sort_order' => 2],
            ['title' => 'Adalah pelajar', 'value' => '35%', 'description' => 'Adalah pelajar', 'sort_order' => 3],
            ['title' => 'Rehabilitasi', 'value' => '530', 'description' => 'Rehabilitasi', 'sort_order' => 4],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('drug_facts', true);
    }
}
