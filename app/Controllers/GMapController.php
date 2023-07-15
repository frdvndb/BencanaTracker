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

        date_default_timezone_set('Asia/Makassar');

        // Mengambil waktu 1 minggu yang lalu
        $oneWeekAgo = date('Y-m-d', strtotime('-1 week'));

        $query = $queryBuilder->select('*')->where('tanggal >=', $oneWeekAgo)->get();
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
            
            if (!empty($value->lokasi_terdeteksi)) {
                $lokasiTerdeteksi = $value->lokasi_terdeteksi;
            } else {
                $lokasiTerdeteksi = "Lokasi tidak tersedia";
            }
        
            $locInfo[] = [
                "<div class='info_content'> <h4>". (strlen($value->peristiwa) > 25 ? substr($value->peristiwa, 0, 25).'...' : $value->peristiwa) ."</h4> <p>". (strlen($value->detail) > 40 ? substr($value->detail, 0, 40).'...' : $value->detail) ."</p> <h6> Lokasi yang terdeteksi: </h6> <p>" . (strlen($lokasiTerdeteksi) > 100 ? substr($lokasiTerdeteksi, 0, 100).'...' : $lokasiTerdeteksi) . "</p> <h6> Lokasi menurut pelapor: </h6> <p>" . (strlen($value->nama_lokasi) > 40 ? substr($value->nama_lokasi, 0, 40).'...' : $value->nama_lokasi) . "</p> <h6> Laporan dibuat pada: </h6> <p>" . $value->tanggal . " WITA </p> </div>"
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

            if (!empty($value->lokasi_terdeteksi)) {
                $lokasiTerdeteksi = $value->lokasi_terdeteksi;
            } else {
                $lokasiTerdeteksi = "Lokasi tidak tersedia";
            }
        
            $locInfo[] = [
                "<div class='info_content'> <h4>". (strlen($value->peristiwa) > 25 ? substr($value->peristiwa, 0, 25).'...' : $value->peristiwa) ."</h4> <p>". (strlen($value->detail) > 40 ? substr($value->detail, 0, 40).'...' : $value->detail) ."</p> <h6> Lokasi yang terdeteksi: </h6> <p>" . (strlen($lokasiTerdeteksi) > 100 ? substr($lokasiTerdeteksi, 0, 100).'...' : $lokasiTerdeteksi) . "</p> <h6> Lokasi menurut pelapor: </h6> <p>" . (strlen($value->nama_lokasi) > 40 ? substr($value->nama_lokasi, 0, 40).'...' : $value->nama_lokasi) . "</p> <h6> Laporan dibuat pada: </h6> <p>" . $value->tanggal . " WITA </p> </div>"
            ];        
        }

        $query = $queryBuilder->selectMax('id')->get();
        $result = $query->getRow();

        $location['locationMarkers'] = json_encode($locationMarkers);
        $location['locInfo'] = json_encode($locInfo);
        $location['maxId'] = json_encode($result);

        return $this->response->setJSON($location);
    }

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

        return view('laporan', [
            "laporan" => $laporan,
            "gambarSrc" => $gambarSrc,
            'dataVote' => $vote,
            'dataUser' => $user,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }
    
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
        $playerId = $this->request->getPost('playerId');
        $userId = $this->request->getPost('userID');
    
        $model = new OneSignalPlayerModel();
    
        // Hapus semua baris dengan player ID yang sama, tetapi id user-nya bukan $userId
        $model->where('id_player', $playerId)->whereNotIn('id_user', [$userId])->delete();

        // Cek apakah sudah ada baris dengan player ID dan user ID yang sama
        $existingRow = $model->where('id_player', $playerId)->where('id_user', $userId)->first();

        if (!$existingRow) {
            // Jika tidak ada, simpan player ID ke database
            $data = [
                'id_player' => $playerId,
                'id_user' => $userId
            ];
            $model->insert($data);
        }        
    
        // Periksa apakah user sudah memiliki 10 player ID di database
        $playerIdsCount = $model->where('id_user', $userId)->countAllResults();
        if ($playerIdsCount > 10) {
            // Jika sudah ada 10 player ID, hapus baris dengan ID terendah untuk user
            $lowestIdPlayer = $model->where('id_user', $userId)->orderBy('id', 'ASC')->first();
            $model->delete($lowestIdPlayer['id']);
        }    
    }
    
}