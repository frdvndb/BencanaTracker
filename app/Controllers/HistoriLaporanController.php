<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HistoriLaporanController extends BaseController
{
    public function index()
    {
        return view('histori_laporan', [
            "username" => session()->get('username')
        ]);
    }
}
