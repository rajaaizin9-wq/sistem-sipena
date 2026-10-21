<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAboutSectionsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 150],
            'description' => ['type' => 'TEXT'],
            'link' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('about_sections', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('about_sections', true);
    }
}
