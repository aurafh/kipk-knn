<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDataTestingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
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
            'skor_nilai_seleksi' => [
                'type' => 'DOUBLE',
                'null' => false,
            ],
            'skor_nilai_wawancara' => [
                'type' => 'DOUBLE',
                'null' => false,
            ],
            'skor_nilai_kondisi_ekonomi' => [
                'type' => 'DOUBLE',
                'null' => false,
            ],
            'skor_nilai_hasil_survey' => [
                'type' => 'DOUBLE',
                'null' => false,
            ],
            'skor_prestasi_akademik' => [
                'type' => 'DOUBLE',
                'null' => false,
            ],
            'skor_nilai_prestasi_non_akademik' => [
                'type' => 'DOUBLE',
                'null' => false,
            ],
            'label' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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
            'id_periode' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_sekolah', 'asal_sekolah', 'id_sekolah', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_periode', 'periode', 'id_periode', 'CASCADE', 'CASCADE');
        $this->forge->addKey('id', true);
        $this->forge->createTable('data_testing');
    }

    public function down()
    {
        $this->forge->dropTable('data_testing');
    }
}
