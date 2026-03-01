<?php

namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\TransactionModel;

class Transactions extends BaseController
{
    protected $itemModel;
    protected $transactionModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {
        $data = [
            'title'        => 'Transaksi Penjualan',
            'items'        => $this->itemModel->where('stock >', 0)->findAll(),
            'transactions' => $this->transactionModel->orderBy('transaction_date', 'DESC')->limit(10)->find(),
            'admins'       => ['Azril', 'Rahmat', 'Dede Nasrulloh', 'OJak Abul Rojak']
        ];

        return view('transactions/index', $data);
    }

    public function save()
    {
        $item_id           = $this->request->getPost('item_id');
        $weight            = (float)$this->request->getPost('weight');
        $customer_name     = $this->request->getPost('customer_name');
        $customer_whatsapp = $this->request->getPost('customer_whatsapp');
        $admin_name        = $this->request->getPost('admin_name');

        $item = $this->itemModel->find($item_id);

        if (!$item) {
            return redirect()->to('/transaction')->with('error', 'Item tidak ditemukan!');
        }

        if ($weight > $item['stock']) {
            return redirect()->to('/transaction')->with('error', 'Stok tidak mencukupi!');
        }

        $total_price = $item['price_per_kg'] * $weight;

        $db = \Config\Database::connect();
        $db->transStart();

        // Save transaction
        $this->transactionModel->save([
            'item_id'           => $item_id,
            'item_name'         => $item['name'],
            'customer_name'     => $customer_name,
            'customer_whatsapp' => $customer_whatsapp,
            'admin_name'        => $admin_name,
            'weight'            => $weight,
            'total_price'       => $total_price,
            'transaction_date'  => date('Y-m-d H:i:s')
        ]);

        // Update stock
        $this->itemModel->update($item_id, [
            'stock' => $item['stock'] - $weight
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/transaction')->with('error', 'Transaksi gagal disimpan!');
        }

        return redirect()->to('/transaction')->with('success', 'Transaksi berhasil disimpan!');
    }
}
