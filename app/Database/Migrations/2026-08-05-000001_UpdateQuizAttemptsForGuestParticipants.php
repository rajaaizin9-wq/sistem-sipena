<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateQuizAttemptsForGuestParticipants extends Migration
{
    public function up(): void
    {
        if (! $this->db->fieldExists('participant_name', 'quiz_attempts')) {
            $this->forge->addColumn('quiz_attempts', [
                'participant_name' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'after' => 'user_id'],
                'participant_age' => ['type' => 'TINYINT', 'constraint' => 3, 'unsigned' => true, 'null' => true, 'after' => 'participant_name'],
            ]);
        }

        if ($this->db->fieldExists('user_id', 'quiz_attempts')) {
            $this->forge->modifyColumn('quiz_attempts', [
                'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            ]);
        }
    }

    public function down(): void
    {
        if ($this->db->fieldExists('participant_name', 'quiz_attempts')) {
            $this->forge->dropColumn('quiz_attempts', ['participant_name', 'participant_age']);
        }
    }
}
