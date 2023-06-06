<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
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

        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
        $location_name = $this->request->getPost('location_name');
        $info = $this->request->getPost('info');
        $model = new LaporanModel();
        $model->insert([
            "latitude" => $latitude,
            "longitude" => $longitude,
            "location_name" => $location_name,
            "info" => $info,
        ]);

        return redirect()->to(base_url('/beranda'));
    }
}
