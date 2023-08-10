<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePeserta extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_peserta' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'no_pendaftaran' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'nama_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jenis_kel' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'nisn' => [
                'type' => 'INT',
                'constraint' => 13,
            ],
            'no_wa' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'id_prodi' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'id_sekolah' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'nama_sekolah' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'bukti' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'label' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,

            ],
            'id_periode' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_sekolah', 'asal_sekolah', 'id_sekolah', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_periode', 'periode', 'id_periode', 'CASCADE', 'CASCADE');
        $this->forge->addKey('id_peserta', true);
        $this->forge->createTable('data_peserta');
    }

    public function down()
    {
        $this->forge->dropTable('data_peserta');
    }
}
