<?php

namespace App\Controllers;

use App\Models\LaporanBencanaModel;
use App\Controllers\BaseController;

class GMapController extends BaseController
{
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

        $query = $queryBuilder->select('*')->limit(30)->get();
        $records = $query->getResult();

        $locationMarkers = [];
        $locInfo = [];

        foreach ($records as $value) {
            $locationMarkers[] = [
                $value->peristiwa,
                $value->garis_lintang,
                $value->garis_bujur
            ];
            $locInfo[] = [
                "<div class=info_content><h4>".$value->peristiwa."</h4><p>".$value->detail."</p></div>"
            ];
        }

        $location['locationMarkers'] = json_encode($locationMarkers);
        $location['locInfo'] = json_encode($locInfo);

        return view('index', array_merge([
            "username" => session()->get('username')
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

    public function laporan()
    {
        $model = new LaporanBencanaModel();
        return view('laporan', [
            "username" => session()->get('username')
        ]);
    }

    public function laporkan_laporan()
    {
        return view('laporkan_laporan', [
            "username" => session()->get('username')
        ]);
    }
    
    public function notifikasi()
    {
        return view('notifikasi', [
            "username" => session()->get('username')
        ]);
    }

    public function komentar()
    {
        return view('komentar', [
            "username" => session()->get('username')
        ]);
    }

}
