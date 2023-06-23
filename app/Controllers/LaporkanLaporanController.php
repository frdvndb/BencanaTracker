<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HistoriLaporanModel;
use App\Models\LaporanBencanaModel;
use App\Models\LaporkanLaporanModel;

class LaporkanLaporanController extends BaseController
{
    public function laporkan_laporan($id)
    {
        $model = new LaporanBencanaModel();
        return view('laporkan_laporan', [
            "data" => $model->find($id),
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function submitPelaporanLaporan($id)
    {
        $model = new LaporkanLaporanModel();
        $historiModel = new HistoriLaporanModel();
        $id_pelapor_bencana = $historiModel->select('id_user')->where('id_laporan', $id)->first();
        $model->insert([
            'id_laporan' => $id,
            "id_pelapor_bencana" => $id_pelapor_bencana['id_user'],
            'id_pelapor_laporan' => session()->get('id'),
            'alasan' => $this->request->getPost('alasan')
        ]);
        session()->setFlashdata('success', 'Berhasil Melaporkan Laporan.');
        return redirect()->to(base_url('/laporan/'.$id));
    }
}
