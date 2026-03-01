<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['transaction_code', 'item_id', 'item_name', 'customer_name', 'customer_whatsapp', 'admin_name', 'weight', 'total_price', 'transaction_date'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // No updated field for transactions

    // Validation
    protected $validationRules      = [
        'transaction_code'  => 'required',
        'item_id'           => 'required|is_natural_no_zero',
        'item_name'         => 'required',
        'customer_name'     => 'required|min_length[3]',
        'customer_whatsapp' => 'required',
        'admin_name'        => 'required',
        'weight'            => 'required|numeric|greater_than[0]',
        'total_price'       => 'required|numeric|greater_than_equal_to[0]',
        'transaction_date'  => 'required|valid_date[Y-m-d H:i:s]',
    ];
}
