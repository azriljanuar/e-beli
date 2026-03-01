<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\ExpenseModel;

class Expenses extends BaseController
{
    protected $expenseModel;

    public function __construct()
    {
        $this->expenseModel = new ExpenseModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Pengeluaran',
            'expenses' => $this->expenseModel->orderBy('expense_date', 'DESC')->findAll()
        ];

        return view('expenses/index', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $data = [
            'description'  => $this->request->getPost('description'),
            'amount'       => $this->request->getPost('amount'),
            'expense_date' => date('Y-m-d H:i:s'),
        ];

        if ($id) {
            $this->expenseModel->update($id, $data);
            return redirect()->to('/expenses')->with('success', 'Pengeluaran berhasil diperbarui');
        } else {
            $this->expenseModel->save($data);
            return redirect()->to('/expenses')->with('success', 'Pengeluaran berhasil ditambahkan');
        }
    }

    public function delete($id)
    {
        $this->expenseModel->delete($id);
        return redirect()->to('/expenses')->with('success', 'Pengeluaran berhasil dihapus');
    }
}
