<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransactionCodeToTransactions extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transactions', [
            'transaction_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'after'      => 'id',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transactions', 'transaction_code');
    }
}
