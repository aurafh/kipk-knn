<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPeriode extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_periode' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'periode' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                // 'unsigned' => true,
            ]
        ]);
        $this->forge->addKey('id_periode', true);
        $this->forge->createTable('periode');
    }

    public function down()
    {
        $this->forge->dropTable('periode');
    }
}
