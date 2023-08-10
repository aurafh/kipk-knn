<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProdi extends Migration
{
    public function up()
    {
        $data = [
            [
                'nama_prodi' => 'Teknik Industri',
                'nilai_atribut_prodi' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_prodi' => 'Teknik Informatika',
                'nilai_atribut_prodi' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_prodi' => 'Teknik Sipil',
                'nilai_atribut_prodi' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('prodi')->insertBatch($data);
    }

    public function down()
    {
        $this->db->table('prodi')->where('nama_prodi', 'Teknik Industri')->delete();
        $this->db->table('prodi')->where('nama_prodi', 'Teknik Informatika')->delete();
        $this->db->table('prodi')->where('nama_prodi', 'Teknik Sipil')->delete();
    }
}
