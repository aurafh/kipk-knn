<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_prodi' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_prodi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'nilai_atribut_prodi' => [
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
        $this->forge->addKey('id_prodi', true);
        $this->forge->createTable('prodi');
    }

    public function down()
    {
        $this->forge->dropTable('prodi');
    }
}
