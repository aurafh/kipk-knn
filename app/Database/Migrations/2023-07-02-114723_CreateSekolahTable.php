<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSekolahTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sekolah' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'jenis_sekolah' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'nilai_atribut' => [
                'type' => 'DOUBLE',
                'unsigned' => true,
                'null' => false,
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
        $this->forge->addKey('id_sekolah', true);
        $this->forge->createTable('asal_sekolah');
    }

    public function down()
    {
        $this->forge->dropTable('asal_sekolah');
    }
}
