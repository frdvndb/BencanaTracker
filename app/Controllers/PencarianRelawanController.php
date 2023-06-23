<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RelawanModel;

class PencarianRelawanController extends BaseController
{
    protected $helpers = ['form'];
    public function index()
    {
        $model = new RelawanModel();
        $data = $model->where('diverifikasi', 1)->findAll();
        return view('pencarianrelawan', [
            "data" => $data,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function pencarianRelawan()
    {
        // Mendapatkan kueri dari input formulir.
        $query = $this->request->getGet('query');

        $model = new relawanModel();

        // Pengembalian hasil pencarian ke view.
        return view('pencarianrelawan', [ 
            "data" => $model->cariRelawan($query),
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function detail_relawan($id)
    {
        $model = new RelawanModel();
        $relawan = $model->find($id);

        $gambarBase64 = base64_encode($relawan['gambar_relawan']);
        $gambarSrc = 'data:image/jpeg;base64,' . $gambarBase64;

        return view('relawan', [
            "relawan" => $relawan,
            "gambarSrc" => $gambarSrc,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }
    public function daftarMenjadiRelawanView()
    {
        return view('daftar_relawan', [
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }


    public function daftarMenjadiRelawanAdd()
    {
        if(!$this->validate('aturanRelawan')){
            return redirect()->back()->withInput();  
        }

        $model = new RelawanModel();
        $gambar_relawan= $this->request->getFile('gambar_relawan');
        $fileData = file_get_contents($gambar_relawan->getTempName());

        $model->insert([
            "nama" =>  $this->request->getPost('nama'),
            "jenis_bencana" => $this->request->getPost('jenis_bencana'),
            "detail" =>$this->request->getPost('detail'),
            "gambar_relawan" => $fileData,
            "no_hp" => $this->request->getPost('no_hp'),
            "email"=> $this->request->getPost('email')
        ]);
        session()->setFlashdata('success', 'Admin akan memverifikasi dalam waktu kurang lebih 2 minggu');
        return redirect()->to(base_url('pencarianrelawan'));
    }
}
