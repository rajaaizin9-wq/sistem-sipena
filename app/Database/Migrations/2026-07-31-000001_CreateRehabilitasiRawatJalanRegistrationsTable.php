<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRehabilitasiRawatJalanRegistrationsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'client_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'client_nik' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'gender' => [
                'type'       => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
            ],
            'birth_place' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'birth_date' => [
                'type' => 'DATE',
            ],
            'client_age' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
            ],
            'client_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'client_address' => [
                'type' => 'TEXT',
            ],
            'guardian_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'guardian_nik' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'guardian_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'purpose' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'guardian_address' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('rehabilitasi_rawat_jalan_registrations', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('rehabilitasi_rawat_jalan_registrations', true);
    }
}
