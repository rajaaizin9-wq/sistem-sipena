<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubmissionColumnsToQuizAttempts extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('quiz_attempts', [
            'submission_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'after' => 'id'],
        ]);

        $this->forge->addColumn('quiz_attempts', [
            'submitted_at' => ['type' => 'DATETIME', 'null' => true, 'after' => 'created_at'],
        ]);

        $this->forge->addColumn('quiz_attempts', [
            'updated_at' => ['type' => 'DATETIME', 'null' => true, 'after' => 'submitted_at'],
        ]);

        $this->db->query("UPDATE quiz_attempts SET submitted_at = COALESCE(submitted_at, created_at) WHERE submitted_at IS NULL");
    }

    public function down(): void
    {
        $this->forge->dropColumn('quiz_attempts', 'submission_id');
        $this->forge->dropColumn('quiz_attempts', 'submitted_at');
        $this->forge->dropColumn('quiz_attempts', 'updated_at');
    }
}
