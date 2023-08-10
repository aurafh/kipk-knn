<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSekolah extends Migration
{
    public function up()
    {
        $data = [
            [
                'jenis_sekolah' => 'MA',
                'nilai_atribut' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'jenis_sekolah' => 'SMA',
                'nilai_atribut' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'jenis_sekolah' => 'SMK',
                'nilai_atribut' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('asal_sekolah')->insertBatch($data);
    }

    public function down()
    {
        $this->db->table('asal_sekolah')->where('jenis_sekolah', 'MA')->delete();
        $this->db->table('asal_sekolah')->where('jenis_sekolah', 'SMA')->delete();
        $this->db->table('asal_sekolah')->where('jenis_sekolah', 'SMK')->delete();
    }
}
