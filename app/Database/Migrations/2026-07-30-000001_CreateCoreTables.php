<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Humas;

class CreateCoreTables extends Migration
{
    public function up(): void
    {
        $this->createUsersTable();
        $this->createScormModulesTable();
        $this->createSiteSettingsTable();
    }

    public function down(): void
    {
        $this->forge->dropTable('scorm_modules', true);
        $this->forge->dropTable('site_settings', true);
        $this->forge->dropTable('users', true);
    }

    private function createUsersTable(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => Humas::ROLES,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');

        $this->forge->createTable('users', true);
    }

    private function createScormModulesTable(): void
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'version' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'folder_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'launch_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'thumbnail' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'published' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('folder_name');

        $this->forge->addForeignKey(
            'created_by',
            'users',
            'id',
            'CASCADE',
            'SET NULL'
        );

        $this->forge->createTable('scorm_modules', true);
    }

    private function createSiteSettingsTable(): void
    {
        $this->forge->addField([
            'setting_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'setting_value' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('setting_key', true);

        $this->forge->createTable('site_settings', true);
    }
}
