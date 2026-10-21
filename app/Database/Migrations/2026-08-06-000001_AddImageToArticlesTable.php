<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageToArticlesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('articles', [
            'image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'content'],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('articles', 'image');
    }
}
