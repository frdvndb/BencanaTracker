<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KomentarModel;
use App\Models\LaporanBencanaModel;

class KomentarController extends BaseController
{
    public function komentar($id)
    {
        $modelLaporan = new LaporanBencanaModel();
        $modelKomentar = new KomentarModel();
        return view('komentar', [
            "dataLaporan" => $modelLaporan->find($id),
            "dataKomentar" => $modelKomentar->join('user', 'user.id = komentar.id_user')->where('komentar.id_laporan', $id)->findAll(),
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function buatKomentar($id)
    {
        $model = new KomentarModel();
        date_default_timezone_set('Asia/Makassar');
        $model->insert([
            'id_laporan' => $id,
            'id_user' => session()->get('id'),
            'komentar' => $this->request->getPost('komentar'),
            'tanggal' => date('Y-m-d H:i:s')
        ]);
        session()->setFlashdata('success', 'Berhasil Melaporkan Laporan.');
        return redirect()->to(base_url('/komentar/'.$id));
    }
}
