<?php

namespace App\Controllers;

use App\Models\ItemModel;

class Items extends BaseController
{
    protected $itemModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Master Daging',
            'items' => $this->itemModel->findAll()
        ];

        return view('items/index', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $data = [
            'name'         => $this->request->getPost('name'),
            'price_per_kg' => $this->request->getPost('price_per_kg'),
            'stock'        => $this->request->getPost('stock'),
        ];

        if ($id) {
            $this->itemModel->update($id, $data);
            return redirect()->to('/master')->with('success', 'Data daging berhasil diperbarui');
        } else {
            $this->itemModel->save($data);
            return redirect()->to('/master')->with('success', 'Data daging berhasil ditambahkan');
        }
    }

    public function delete($id)
    {
        $this->itemModel->delete($id);
        return redirect()->to('/master')->with('success', 'Data daging berhasil dihapus');
    }
}
