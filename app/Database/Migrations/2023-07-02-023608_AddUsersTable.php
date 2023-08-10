<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsersTable extends Migration
{
    public function up()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('itg@garut', PASSWORD_DEFAULT),
                'role' => 'Admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'operator',
                'password' => password_hash('itg@garut', PASSWORD_DEFAULT),
                'role' => 'Operator',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('users')->insertBatch($data);
    }

    public function down()
    {
        $this->db->table('users')->where('username', 'admin')->delete();
        $this->db->table('users')->where('username', 'operator')->delete();
    }
}
