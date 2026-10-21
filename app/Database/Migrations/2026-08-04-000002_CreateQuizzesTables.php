<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizzesTables extends Migration
{
    public function up(): void
    {
        // Create quizzes (metadata only)
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('quizzes', true);

        // Create quiz_questions (one quiz can have many questions)
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'quiz_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'question' => ['type' => 'TEXT'],
            'option_a' => ['type' => 'VARCHAR', 'constraint' => 255],
            'option_b' => ['type' => 'VARCHAR', 'constraint' => 255],
            'option_c' => ['type' => 'VARCHAR', 'constraint' => 255],
            'option_d' => ['type' => 'VARCHAR', 'constraint' => 255],
            'correct_option' => ['type' => 'TINYINT', 'constraint' => 1],
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('quiz_id', 'quizzes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quiz_questions', true);

        // Create quiz_attempts (record answer per question)
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'quiz_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'question_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'participant_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'participant_age' => ['type' => 'TINYINT', 'constraint' => 3, 'unsigned' => true],
            'answer' => ['type' => 'TINYINT', 'constraint' => 1],
            'is_correct' => ['type' => 'TINYINT', 'constraint' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('quiz_id', 'quizzes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('question_id', 'quiz_questions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('quiz_attempts', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('quiz_attempts', true);
        $this->forge->dropTable('quiz_questions', true);
        $this->forge->dropTable('quizzes', true);
    }
}
