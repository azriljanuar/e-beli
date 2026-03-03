<?php

namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\TransactionModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $itemModel        = new ItemModel();
        $transactionModel = new TransactionModel();

        $items        = $itemModel->findAll();
        $transactions = $transactionModel->orderBy('transaction_date', 'DESC')->limit(5)->find();

        $totalRevenue       = array_sum(array_column($transactionModel->findAll(), 'total_price'));
        $totalStockRemaining = array_sum(array_column($items, 'stock'));
        $totalTransactions   = $transactionModel->select('transaction_code')->distinct()->countAllResults();

        // Rekap total barang yang dipesan (terjual)
        $soldRecap = $transactionModel->select('item_name, SUM(weight) as total_weight')
                                      ->groupBy('item_name')
                                      ->findAll();

        $data = [
            'title'               => 'Beranda Dashboard',
            'totalRevenue'        => $totalRevenue,
            'totalStockRemaining' => $totalStockRemaining,
            'totalTransactions'   => $totalTransactions,
            'items'               => $items,
            'transactions'        => $transactionModel->orderBy('transaction_date', 'DESC')->limit(10)->find(),
            'soldRecap'           => $soldRecap
        ];

        return view('dashboard/index', $data);
    }
}
