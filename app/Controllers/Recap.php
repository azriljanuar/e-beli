<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\ExpenseModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Recap extends BaseController
{
    public function index()
    {
        $transactionModel = new TransactionModel();
        $expenseModel = new ExpenseModel();

        $transactions = $transactionModel->findAll();
        $expenses = $expenseModel->findAll();

        $totalSales = array_sum(array_column($transactions, 'total_price'));
        $totalExpenses = array_sum(array_column($expenses, 'amount'));
        $netProfit = $totalSales - $totalExpenses;

        // Group transactions for the view list
        $groupedTx = [];
        $rawTransactions = $transactionModel->orderBy('transaction_date', 'DESC')->findAll();
        foreach ($rawTransactions as $tx) {
            $groupedTx[$tx['transaction_code']][] = $tx;
        }

        $data = [
            'title'         => 'Rekapitulasi Keuangan',
            'totalSales'    => $totalSales,
            'totalExpenses' => $totalExpenses,
            'netProfit'     => $netProfit,
            'groupedTx'     => array_slice($groupedTx, 0, 10), // Limit to 10 orders
            'expenses'      => $expenseModel->orderBy('expense_date', 'DESC')->limit(10)->find()
        ];

        return view('recap/index', $data);
    }

    public function downloadPdf()
    {
        $transactionModel = new TransactionModel();
        $expenseModel = new ExpenseModel();

        $transactions = $transactionModel->orderBy('transaction_date', 'ASC')->findAll();
        $expenses = $expenseModel->orderBy('expense_date', 'ASC')->findAll();

        $totalSales = array_sum(array_column($transactions, 'total_price'));
        $totalExpenses = array_sum(array_column($expenses, 'amount'));
        $netProfit = $totalSales - $totalExpenses;

        $groupedTx = [];
        foreach ($transactions as $tx) {
            $groupedTx[$tx['transaction_code']][] = $tx;
        }

        $data = [
            'groupedTx'     => $groupedTx,
            'expenses'      => $expenses,
            'totalSales'    => $totalSales,
            'totalExpenses' => $totalExpenses,
            'netProfit'     => $netProfit,
            'date'          => date('d/m/Y H:i')
        ];

        $html = view('recap/pdf_template', $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Rekapitulasi-eBeli-' . date('YmdHis') . '.pdf';
        $dompdf->stream($filename, ['Attachment' => 1]);
    }
}
