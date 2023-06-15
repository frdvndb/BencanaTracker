<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HistoriLaporanModel;
use App\Models\LaporanBencanaModel;


class BuatLaporanController extends BaseController
{
    protected $helpers = ['form'];
    public function index()
    {
        return view("buat_laporan", [
            "username" => session()->get('username')
        ]);
    }

    public function buat()
    {
    $gambar_peristiwa = $this->request->getFile('gambar_peristiwa');
    $fileData = file_get_contents($gambar_peristiwa->getTempName());

        $model = new LaporanBencanaModel();
        $detail = $this->request->getPost('detail');
        $detailDenganBR = str_replace("\r\n", "<br>", $detail);
        
        $model->insert([
            'garis_lintang' => $this->request->getPost('garis_lintang'),
            'garis_bujur' => $this->request->getPost('garis_bujur'),
            'nama_lokasi' => $this->request->getPost('nama_lokasi'),
            'peristiwa' => $this->request->getPost('peristiwa'),
            'gambar_peristiwa' => $fileData,
            'detail' => $detailDenganBR,
        ]);
 
        $modelHistori = new HistoriLaporanModel();
        $modelHistori->insert([
            "id_user" => session()->get('id'),
            "id_laporan" => $model->insertID()
        ]);
        return redirect()->to(base_url('/beranda'));
    }

}