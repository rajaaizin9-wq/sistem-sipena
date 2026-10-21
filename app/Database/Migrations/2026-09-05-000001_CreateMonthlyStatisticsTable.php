<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMonthlyStatisticsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'year'        => ['type' => 'INT', 'constraint' => 4, 'unsigned' => true],
            'month'       => ['type' => 'INT', 'constraint' => 2, 'unsigned' => true],
            'skhpn_count' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'rehab_count' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['year', 'month']);
        $this->forge->createTable('monthly_statistics', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('monthly_statistics', true);
    }
}
