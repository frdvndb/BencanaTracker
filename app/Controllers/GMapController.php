<?php

namespace App\Controllers;

use App\Models\LaporanBencanaModel;
use App\Controllers\BaseController;
use App\Models\HistoriLaporanModel;
use App\Models\OneSignalPlayerModel;
use App\Models\UserModel;
use App\Models\VoteModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CURLRequest;

class GMapController extends BaseController
{
    public function landingPage(){
        return view('landing',[
            "username" => session()->get('username'),
            "userID" => session()->get('id'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }
    public function showMap()
    {
        $database = \Config\Database::connect();
        $queryBuilder = $database->table('laporan_bencana');

        // if ($this->request->getMethod() === 'post') {
        //     $locationName = $this->request->getPost('peristiwa');
        //     $latitude = $this->request->getPost('latitude');
        //     $longitude = $this->request->getPost('longitude');

        //     $data = [
        //         'location_name' => $locationName,
        //         'latitude' =>  $latitude,
        //         'longitude' => $longitude
        //     ];

        //     $queryBuilder->insert($data);
        // }

        $query = $queryBuilder->select('*')->get();
        $records = $query->getResult();

        $locationMarkers = [];
        $locInfo = [];

        foreach ($records as $value) {
            $locationMarkers[] = [
                $value->peristiwa,
                $value->garis_lintang,
                $value->garis_bujur,
                $value->id
            ];
            $locInfo[] = [
                "<div class='info_content'> <h4>". (strlen($value->peristiwa) > 25 ? substr($value->peristiwa, 0, 25).'...' : $value->peristiwa) ."</h4> <p>". (strlen($value->detail) > 40 ? substr($value->detail, 0, 40).'...' : $value->detail) ."</p> </div>"
            ];
        }

        $query = $queryBuilder->selectMax('id')->get();
        $result = $query->getRow();

        $location['locationMarkers'] = json_encode($locationMarkers);
        $location['locInfo'] = json_encode($locInfo);
        $location['maxId'] = json_encode($result);

        return view('index', array_merge([
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ], $location)); 
    }

    public function getLatestReports($id)
    {
        $database = \Config\Database::connect();
        $queryBuilder = $database->table('laporan_bencana');

        $query = $queryBuilder->select('*')->where('id >', $id)->get();
        $records = $query->getResult();

        $locationMarkers = [];
        $locInfo = [];

        foreach ($records as $value) {
            $locationMarkers[] = [
                $value->peristiwa,
                $value->garis_lintang,
                $value->garis_bujur,
                $value->id
            ];
            $locInfo[] = [
                "<div class='info_content'> <h4>". (strlen($value->peristiwa) > 25 ? substr($value->peristiwa, 0, 25).'...' : $value->peristiwa) ."</h4> <p>". (strlen($value->detail) > 40 ? substr($value->detail, 0, 40).'...' : $value->detail) ."</p> </div>"
            ];
        }

        $query = $queryBuilder->selectMax('id')->get();
        $result = $query->getRow();

        $location['locationMarkers'] = json_encode($locationMarkers);
        $location['locInfo'] = json_encode($locInfo);
        $location['maxId'] = json_encode($result);

        return $this->response->setJSON($location);
    }


    // public function donasi()
    // {
    //     return view('donasi', [
    //         "username" => session()->get('username'),
    //         "isAdmin" => session()->get('isAdmin')
    //     ]);
    // }

    public function pencarianrelawan()
    {
        return view('pencarianrelawan', [
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function laporan($id)
    {


        $model = new LaporanBencanaModel();
        $laporan = $model->find($id);

        $sessionNow = session()->get('id');
        $modelVote = new VoteModel();
        $vote = $modelVote->where('id_laporan', $id)
        ->where('id_user',$sessionNow)
        ->first();

        
        $modelHistori = new HistoriLaporanModel();
        $user = $modelHistori->select('histori_laporan.*, user.*')
            ->join('user', 'user.id = histori_laporan.id_user')
            ->where('histori_laporan.id_laporan', $id)
            ->first();
    
        $gambarBase64 = base64_encode($laporan['gambar_peristiwa']);
        $gambarSrc = 'data:image/jpeg;base64,' . $gambarBase64;

        //$url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$laporan['garis_lintang']}&lon={$laporan['garis_bujur']}";

        $lat = -6.1754;  // contoh koordinat garis lintang
        $lon = 106.8272;  // contoh koordinat garis bujur

        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$laporan['garis_lintang']}&lon={$laporan['garis_bujur']}";

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
        
        return view('laporan', [
            "laporan" => $laporan,
            "gambarSrc" => $gambarSrc,
            "lokasi" => $lokasi,
            'dataVote' => $vote,
            'dataUser' => $user,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    // public function laporkan_laporan()
    // {
    //     return view('laporkan_laporan', [
    //         "username" => session()->get('username'),
    //         "isAdmin" => session()->get('isAdmin')
    //     ]);
    // }
    
    public function notifikasi()
    {
        return view('notifikasi', [
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function komentar()
    {
        return view('komentar', [
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function beranda()
    {
        return view('beranda', [
            "username" => session()->get('username')
        ]);
    }

    public function simpanPlayerID()
    {
        $playerId = $this->request->getPost('playerId'); // Dapatkan player ID dari permintaan POST
        $userId = $this->request->getPost('userID'); // Dapatkan user ID dari permintaan POST
    
        $model = new OneSignalPlayerModel();
    
        // Hapus semua baris dengan player ID yang sama, tetapi id user-nya bukan $userId
        $model->where('id_player', $playerId)->whereNotIn('id_user', [$userId])->delete();

        // Cek apakah sudah ada baris dengan player ID dan user ID yang sama
        $existingRow = $model->where('id_player', $playerId)->where('id_user', $userId)->first();

        if (!$existingRow) {
            // Jika tidak ada baris yang ada, simpan player ID ke database
            $data = [
                'id_player' => $playerId,
                'id_user' => $userId
            ];
            $model->insert($data);
        }        
    
        // Check if the user already has 10 player IDs in the database
        $playerIdsCount = $model->where('id_user', $userId)->countAllResults();
        if ($playerIdsCount > 10) {
            // If there are already 10 player IDs, delete the row with the lowest ID for the user
            $lowestIdPlayer = $model->where('id_user', $userId)->orderBy('id', 'ASC')->first();
            $model->delete($lowestIdPlayer['id']);
        }    
    }
    
}