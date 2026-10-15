<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAvatarToUsers extends Migration
{
    public function up()
    {
        if (
            $this->db->tableExists('users')
            && ! $this->db->fieldExists('avatar', 'users')
        ) {
            $this->forge->addColumn('users', [
                'avatar' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'created_at',
                ],
            ]);
        }
    }

    public function down()
    {
        if (
            $this->db->tableExists('users')
            && $this->db->fieldExists('avatar', 'users')
        ) {
            $this->forge->dropColumn('users', 'avatar');
        }
    }
}
