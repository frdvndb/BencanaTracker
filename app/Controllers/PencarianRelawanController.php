<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RelawanModel;

class PencarianRelawanController extends BaseController
{
    public function index()
    {
        $model = new RelawanModel();
        return view('pencarianrelawan', [
            "data" => $model->findAll(),
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function pencarianRelawan()
    {
        // Mendapatkan kueri dari input formulir.
        $query = $this->request->getGet('query');

        $model = new relawanModel();

        // Pengembalian hasil pencarian ke view.
        return view('pencarianrelawan', [ 
            "data" => $model->cariRelawan($query),
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function detail_relawan($id)
    {
        $model = new RelawanModel();
        $relawan = $model->find($id);

        $gambarBase64 = base64_encode($relawan['gambar_relawan']);
        $gambarSrc = 'data:image/jpeg;base64,' . $gambarBase64;

        return view('relawan', [
            "relawan" => $relawan,
            "gambarSrc" => $gambarSrc,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }
}
