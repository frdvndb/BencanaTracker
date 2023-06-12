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
            "username" => session()->get('username')
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
        ]);
    }

}
