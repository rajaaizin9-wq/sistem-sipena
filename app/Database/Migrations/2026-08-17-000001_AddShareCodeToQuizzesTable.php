<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddShareCodeToQuizzesTable extends Migration
{
    public function up(): void
    {
        $fields = [
            'share_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
                'after'      => 'title',
            ],
        ];

        $this->forge->addColumn('quizzes', $fields);
    }

    public function down(): void
    {
        $this->forge->dropColumn('quizzes', 'share_code');
    }
}
