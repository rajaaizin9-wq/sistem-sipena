<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDescriptionToArticlesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('articles', [
            'description' => ['type' => 'TEXT', 'null' => true, 'after' => 'tag'],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('articles', 'description');
    }
}
