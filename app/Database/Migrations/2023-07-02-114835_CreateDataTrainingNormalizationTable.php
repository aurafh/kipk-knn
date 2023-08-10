<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDataTrainingNormalizationTable extends Migration
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
            'pilihan_program_studi' => [
                'type' => 'DOUBLE',
                'unsigned' => true,
                'null' => false,
            ],
            'asal_sekolah' => [
                'type' => 'DOUBLE',
                'unsigned' => true,
                'null' => false,
            ],
            'skor_nilai_seleksi' => [
                'type' => 'DOUBLE',
                'unsigned' => true,
                'null' => false,
            ],
            'skor_nilai_wawancara' => [
                'type' => 'DOUBLE',
                'unsigned' => true,
                'null' => false,
            ],
            'skor_nilai_kondisi_ekonomi' => [
                'type' => 'DOUBLE',
                'unsigned' => true,
                'null' => false,
            ],
            'skor_nilai_hasil_survey' => [
                'type' => 'DOUBLE',
                'unsigned' => true,
                'null' => false,
            ],
            'skor_prestasi_akademik' => [
                'type' => 'DOUBLE',
                'unsigned' => true,
                'null' => false,
            ],
            'skor_nilai_prestasi_non_akademik' => [
                'type' => 'DOUBLE',
                'unsigned' => true,
                'null' => false,
            ],
            'label' => [
                'type' => 'INT',
                'constraint' => 5,
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
        $this->forge->createTable('data_training_normalization');
    }

    public function down()
    {
        $this->forge->dropTable('data_training_normalization');
    }
}
