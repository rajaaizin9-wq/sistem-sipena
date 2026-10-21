<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTagToArticlesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('articles', [
            'tag' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'title'],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('articles', 'tag');
    }
}
