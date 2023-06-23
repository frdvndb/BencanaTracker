<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HistoriLaporanModel;
use App\Models\LaporanBencanaModel;
use App\Models\NotifikasiLaporanModel;
use App\Models\UserModel;

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
        $detailDenganBR = str_replace("\"", "'", $detailDenganBR);
        
        $model->insert([
            'garis_lintang' => $this->request->getPost('garis_lintang'),
            'garis_bujur' => $this->request->getPost('garis_bujur'),
            'nama_lokasi' => $this->request->getPost('nama_lokasi'),
            'peristiwa' => $this->request->getPost('peristiwa'),
            'gambar_peristiwa' => $fileData,
            'detail' => $detailDenganBR,
        ]);
        $sessionNow = session()->get('id');
        $idlaporanNow = $model->insertID();
        $modelHistori = new HistoriLaporanModel();
        $modelHistori->insert([
            "id_user" => $sessionNow,
            "id_laporan" => $idlaporanNow
        ]);
        $modelNotifikasi = new NotifikasiLaporanModel();

        $modelUser = new UserModel();
        $data = $modelUser->findAll();

        function calculateDistance($latitude1, $longitude1, $latitude2, $longitude2) {
            $earthRadius = 6371; // radius bumi dalam kilometer
        
            $deltaLat = deg2rad($latitude2 - $latitude1);
            $deltaLon = deg2rad($longitude2 - $longitude1);
        
            $a = sin($deltaLat/2) * sin($deltaLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($deltaLon/2) * sin($deltaLon/2);
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            $distance = $earthRadius * $c;
        
            return $distance;
        }

        foreach ($data as $baris) {
            $garis_lintang_temp = (double) $baris['garis_lintang'];
            $garis_bujur_temp = (double)  $baris['garis_bujur'];
            $jarakLaporanKeUser = calculateDistance($garis_lintang_temp, $garis_bujur_temp, (double) $this->request->getPost('garis_lintang'), (double) $this->request->getPost('garis_bujur'));
            if ($jarakLaporanKeUser <= 5 && $baris['id'] != $sessionNow) {
                $modelNotifikasi->insert([
                    "id_user" => $baris['id'],
                    "id_laporan" => $idlaporanNow
                ]);        

                $email = \Config\Services::email();
                $alamat_penerima = $baris['email'];
                $email->setTo($alamat_penerima);
                $alamat_pengirim = 'bencanatracker@gmail.com';
                $email->setFrom($alamat_pengirim);
                $subject = 'Bencana Baru';
                $email->setSubject($subject);
                $pesan = 'Seseorang melaporkan bencana: ' . $this->request->getPost('peristiwa') . '<br/>' . $detailDenganBR . '<br/>' . '<a href="' . str_replace('\\', '/', base_url('laporan/')) . $model->getInsertID() . '">Lihat laporan</a>';
                $email->setMessage($pesan);
                $email->send();
            }
        }

        return redirect()->to(base_url('/map'));
    }

}