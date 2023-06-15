<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DonasiModel;
use App\Models\HistoriDonasiModel;

class DonasiController extends BaseController
{
    public function index()
    {
        return view('donasi', [
            "username" => session()->get('username')
        ]);
    }

    public function buatDonasi(){
        $model = new DonasiModel();
        $model->insert([
            'jumlah_uang' => $this->request->getPost('jumlah_uang'),
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
            'nomor_rekening' => $this->request->getPost('nomor_rekening')
        ]);
        $modelHistori = new HistoriDonasiModel();
        $modelHistori->insert([
            "id_user" => session()->get('id'),
            "id_donasi" => $model->insertID()
        ]);
        return view('donasi_pesan_berhasil', [
            "username" => session()->get('username')
        ]);
    }
}
