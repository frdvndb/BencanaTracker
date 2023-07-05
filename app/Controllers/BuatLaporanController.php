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
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
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
        session()->setFlashdata('success', 'Berhasil Melaporkan Bencana.');
        $message = "Laporan baru, deskripsi: \n" . $detailDenganBR;
        // $user_id = $this->input->post("user_id");
        $content = array(
            "en" => "$message"
        );

        $fields = array(
            'app_id' => "9c243ca7-57c4-4d7c-9915-888c2167975e",
            'included_segments' => array("All"),
            'contents' => $content
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic MmRiYzliOTEtMWNlMi00MDc4LThlNjAtMTVjNTA5OGMxMzkw'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        // return $response;
        
        return redirect()->to(base_url('/map'));
    }

}