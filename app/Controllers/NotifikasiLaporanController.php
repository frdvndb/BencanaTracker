<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotifikasiLaporanModel;


class NotifikasiLaporanController extends BaseController
{
    public function index()
    {
        $model = new NotifikasiLaporanModel();
    
        $id = session()->get('id');
    
        $data = $model->select('notifikasi_laporan.*, laporan_bencana.*')
            ->join('laporan_bencana', 'laporan_bencana.id = notifikasi_laporan.id_laporan')
            ->where('notifikasi_laporan.id_user', $id)
            ->findAll();
    
        return view('notifikasi', [
            "data" => $data,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }
    
}