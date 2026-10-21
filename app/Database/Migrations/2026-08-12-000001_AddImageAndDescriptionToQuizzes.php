<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageAndDescriptionToQuizzes extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('quizzes', [
            'image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'title'],
            'description' => ['type' => 'TEXT', 'null' => true, 'after' => 'image'],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('quizzes', ['image', 'description']);
    }
}
