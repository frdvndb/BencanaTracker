<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HistoriLaporanModel;
use App\Models\LaporanBencanaModel;
use App\Models\NotifikasiLaporanModel;
use App\Models\OneSignalPlayerModel;
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
        date_default_timezone_set('Asia/Makassar');
        $gambar_peristiwa = $this->request->getFile('gambar_peristiwa');
        $fileData = file_get_contents($gambar_peristiwa->getTempName());

        $model = new LaporanBencanaModel();
        $detail = $this->request->getPost('detail');
        $detailDenganBR = str_replace("\r\n", "<br>", $detail);
        $detailDenganBR = str_replace("\"", "'", $detailDenganBR);

        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=".$this->request->getPost('garis_lintang')."&lon=".$this->request->getPost('garis_bujur');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");

        $response = curl_exec($ch);

        curl_close($ch);

        // return json_decode($response, true);

        // $client = new \CodeIgniter\HTTP\CURLRequest(
        //     new \Config\App(),
        //     new \CodeIgniter\HTTP\URI(),
        //     new \CodeIgniter\HTTP\Response(new \Config\App()),
        // );
        
        // $headers = [
        //     'Referer: http://localhost', // Ganti dengan Referer yang valid
        //     'User-Agent: MyApplication/1.0', // Ganti dengan User-Agent yang valid
        // ];
        
        // $response = $client->request('GET', $url, [], $headers);
        // if ($response->getStatusCode() === 200) {
        //     $data = json_decode($response->getBody(), true);
        //     $nama_lokasi = $data['display_name'];
        //     echo "Nama Lokasi: " . $nama_lokasi;
        // } else {
        //     echo "Permintaan gagal.";
        // }
        
        // $url = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=52.5487429714954&lon=-1.81602098644987&zoom=18&addressdetails=1'; // URL eksternal yang ingin Anda ambil kontennya
        // // Mendapatkan isi konten dari URL eksternal
        // $content = file_get_contents(urlencode($url));

        $lokasi = json_decode($response);
        $lokasi = $lokasi->display_name;
        
        $model->insert([
            'garis_lintang' => $this->request->getPost('garis_lintang'),
            'garis_bujur' => $this->request->getPost('garis_bujur'),
            'nama_lokasi' => $this->request->getPost('nama_lokasi'),
            'lokasi_terdeteksi' => $lokasi,
            'peristiwa' => $this->request->getPost('peristiwa'),
            'gambar_peristiwa' => $fileData,
            'detail' => $detailDenganBR,
            'tanggal'=> date('Y-m-d H:i:s')
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
            $radiusNotif = 0;
            if ($baris['radius_notif'] == null) {
                $radiusNotif = 5;
            } else {
                $radiusNotif = $baris['radius_notif'];
            }
            $garis_lintang_temp = (double) $baris['garis_lintang'];
            $garis_bujur_temp = (double)  $baris['garis_bujur'];
            $jarakLaporanKeUser = calculateDistance($garis_lintang_temp, $garis_bujur_temp, (double) $this->request->getPost('garis_lintang'), (double) $this->request->getPost('garis_bujur'));
            if ($jarakLaporanKeUser <= $radiusNotif && $baris['id'] != $sessionNow) {
                $modelNotifikasi->insert([
                    "id_user" => $baris['id'],
                    "id_laporan" => $idlaporanNow
                ]);        
                if ($baris['push_subscribe'] == 1) {
                    // Mengirim notifikasi OneSignal
                    $playerIds = $this->getPlayerIdsByUserId($baris['id']); // Mendapatkan player IDs berdasarkan user ID
                    if (!empty($playerIds)) {
                        $this->sendOneSignalNotification($playerIds, 'Laporan Baru', 'Seseorang melaporkan bencana: ' . $this->request->getPost('peristiwa') . "\r\n" . $detailDenganBR, base_url('laporan/') . $model->getInsertID());
                    }
                }
                if ($baris['email_subscribe'] == 1) {
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
        }
        session()->setFlashdata('success', 'Berhasil Melaporkan Bencana.');        
        return redirect()->to(base_url('/map'));
    }

    protected function getPlayerIdsByUserId($userId)
    {
        $model = new OneSignalPlayerModel();
        $builder = $model->where('id_user', $userId)->select('id_player')->findAll();

        $playerIds = [];
        foreach ($builder as $row) {
            $playerIds[] = $row['id_player'];
        }

        return $playerIds;
    }

    protected function sendOneSignalNotification($playerIds, $title, $message, $url)
    {
        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => "9c243ca7-57c4-4d7c-9915-888c2167975e",
            'include_player_ids' => $playerIds,
            'headings' => array(
                'en' => $title
            ),
            'contents' => $content,
            'url' => $url
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic MmRiYzliOTEtMWNlMi00MDc4LThlNjAtMTVjNTA5OGMxMzkw'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
    }
}