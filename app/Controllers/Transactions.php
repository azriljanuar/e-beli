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
            'transactions' => $this->transactionModel->orderBy('transaction_date', 'DESC')->findAll(),
            'admins'       => ['Azril', 'Rahmat', 'Dede Nasrulloh', 'OJak Abul Rojak']
        ];

        return view('transactions/index', $data);
    }

    public function save()
    {
        $transaction_code_existing = $this->request->getPost('transaction_code');
        $item_ids                  = $this->request->getPost('item_id');
        $weights                   = $this->request->getPost('weight');
        $customer_name             = $this->request->getPost('customer_name');
        $customer_whatsapp         = $this->request->getPost('customer_whatsapp');
        $admin_name                = $this->request->getPost('admin_name');

        if (empty($item_ids)) {
            return redirect()->to('/transaction')->with('error', 'Pilih minimal satu item!');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // If editing, restore old stocks and delete old records first
        if ($transaction_code_existing) {
            $oldTransactions = $this->transactionModel->where('transaction_code', $transaction_code_existing)->findAll();
            foreach ($oldTransactions as $oldTx) {
                $item = $this->itemModel->find($oldTx['item_id']);
                if ($item) {
                    $this->itemModel->update($oldTx['item_id'], [
                        'stock' => $item['stock'] + $oldTx['weight']
                    ]);
                }
                $this->transactionModel->delete($oldTx['id']);
            }
            $transaction_code = $transaction_code_existing;
        } else {
            $transaction_code = 'TX-' . strtoupper(substr(uniqid(), -6));
        }

        $transaction_date = date('Y-m-d H:i:s');

        foreach ($item_ids as $index => $item_id) {
            $weight = (float)$weights[$index];
            $item = $this->itemModel->find($item_id);

            if (!$item) {
                $db->transRollback();
                return redirect()->to('/transaction')->with('error', 'Item tidak ditemukan!');
            }

            if ($weight > $item['stock']) {
                $db->transRollback();
                return redirect()->to('/transaction')->with('error', "Stok {$item['name']} tidak mencukupi!");
            }

            $total_price = $item['price_per_kg'] * $weight;

            // Save transaction
            $this->transactionModel->save([
                'transaction_code'  => $transaction_code,
                'item_id'           => $item_id,
                'item_name'         => $item['name'],
                'customer_name'     => $customer_name,
                'customer_whatsapp' => $customer_whatsapp,
                'admin_name'        => $admin_name,
                'weight'            => $weight,
                'total_price'       => $total_price,
                'transaction_date'  => $transaction_date
            ]);

            // Update stock
            $this->itemModel->update($item_id, [
                'stock' => $item['stock'] - $weight
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/transaction')->with('error', 'Transaksi gagal disimpan!');
        }

        $msg = $transaction_code_existing ? 'Transaksi berhasil diperbarui!' : 'Transaksi berhasil disimpan!';
        return redirect()->to('/transaction')->with('success', $msg);
    }

    public function delete($transaction_code)
    {
        $transactions = $this->transactionModel->where('transaction_code', $transaction_code)->findAll();

        if (empty($transactions)) {
            return redirect()->to('/transaction')->with('error', 'Transaksi tidak ditemukan!');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($transactions as $tx) {
            // Restore stock
            $item = $this->itemModel->find($tx['item_id']);
            if ($item) {
                $this->itemModel->update($tx['item_id'], [
                    'stock' => $item['stock'] + $tx['weight']
                ]);
            }
            // Delete transaction record
            $this->transactionModel->delete($tx['id']);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/transaction')->with('error', 'Gagal menghapus transaksi!');
        }

        return redirect()->to('/transaction')->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan!');
    }
}
