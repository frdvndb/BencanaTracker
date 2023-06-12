<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HistoriLaporanModel;


class HistoriLaporanController extends BaseController
{
    public function index()
    {
        $model = new HistoriLaporanModel();
    
        $id = session()->get('id');
    
        $data = $model->select('histori_laporan.*, laporan_bencana.*')
            ->join('laporan_bencana', 'laporan_bencana.id = histori_laporan.id_laporan')
            ->where('histori_laporan.id_user', $id)
            ->findAll();
    
        return view('histori_laporan', [
            "data" => $data,
            "username" => session()->get('username')
        ]);
    }
    
}