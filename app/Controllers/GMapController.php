<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\MahasiswaModel;

class GMapController extends Controller
{
    public function showMap()
    {
            // Pembuatan objek
            $mahasiswa = new MahasiswaModel();

            // Menampilkan halaman beranda
            // serta memanggil nilai variabel
            // yang diperlukan oleh halaman
            

        $database = \Config\Database::connect();
        $queryBuilder = $database->table('user_locations');

        if ($this->request->getMethod() === 'post') {
            $locationName = $this->request->getPost('location_name');
            $latitude = $this->request->getPost('latitude');
            $longitude = $this->request->getPost('longitude');

            $data = [
                'location_name' => $locationName,
                'latitude' => $latitude,
                'longitude' => $longitude
            ];

            $queryBuilder->insert($data);
        }

        $query = $queryBuilder->select('*')->limit(30)->get();
        $records = $query->getResult();

        $locationMarkers = [];
        $locInfo = [];

        foreach ($records as $value) {
            $locationMarkers[] = [
                $value->location_name,
                $value->latitude,
                $value->longitude
            ];
            $locInfo[] = [
                "<div class=info_content><h4>".$value->location_name."</h4><p>".$value->info."</p></div>"
            ];
        }

        $location['locationMarkers'] = json_encode($locationMarkers);
        $location['locInfo'] = json_encode($locInfo);

        return view('index', array_merge([
            'nama' => $mahasiswa->getNama(),
            'nim' => $mahasiswa->getNim(),
            'gambarProfil' => $mahasiswa->getGambarProfil(),
            'github' => $mahasiswa->getGithub(),
            'gambarBackground' => $mahasiswa->getgambarBackground(),
            "username" => session()->get('username'),
        ], $location));
        
        
    }

    public function donasi()
    {
        return view('donasi', [
            "username" => session()->get('username')
        ]);
    }

    public function pencarianrelawan()
    {
        return view('pencarianrelawan', [
            "username" => session()->get('username')
        ]);
    }
}
