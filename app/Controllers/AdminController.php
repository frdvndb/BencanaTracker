<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanBencanaModel;
use App\Models\LaporkanLaporanModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $helpers = ['form'];
    public function daftarLaporanBencana()
    {
        $model = new LaporanBencanaModel();
        return view("admin_daftar_lb", [
            'data' => $model->select('laporan_bencana.*, histori_laporan.*')
            ->join('histori_laporan', 'laporan_bencana.id = histori_laporan.id_laporan', 'left')
            ->paginate(10),
            'pager' => $model->pager,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function daftarUser()
    {
        $model = new UserModel();
        return view("admin_daftar_user", [
            'data' => $model->paginate(10),
            'pager' => $model->pager,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function daftarPelaporanLaporan()
    {
        $model = new LaporkanLaporanModel();
        return view("admin_daftar_pelaporan", [
            'data' => $model->paginate(10),
            'pager' => $model->pager,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function deleteLaporanBencana($id){
        $model = new LaporanBencanaModel();
        $model->delete($id);
        return redirect()->to(base_url('admin_daftar_lb'));
    }

    public function deleteUser($id){
        $model = new UserModel();
        $model->delete($id);
        return redirect()->to(base_url('admin_daftar_user'));
    }

    public function deletePelaporanLaporan($id){
        $model = new LaporkanLaporanModel();
        $model->delete($id);
        return redirect()->to(base_url('admin_daftar_pelaporan'));
    }

    public function editUpdateLaporanBencana($id){

        // Validasi aturan buku.
        if(!$this->validate('aturanLaporanBencana')){
            return redirect()->back()->withInput();
        }

        $model = new LaporanBencanaModel();
        $gambar_peristiwa = $this->request->getFile('gambar_peristiwa');
        if ($gambar_peristiwa->getSize() > 0) {
            
            $fileData = file_get_contents($gambar_peristiwa->getTempName());
            $data = [
                "peristiwa" => $this->request->getPost('peristiwa'),
                "nama_lokasi" => $this->request->getPost('nama_lokasi'),
                "detail" => $this->request->getPost('detail'),
                "garis_lintang" => $this->request->getPost('garis_lintang'),
                "garis_bujur" => $this->request->getPost('garis_bujur'),
                'gambar_peristiwa' => $fileData,
            ];
        } else {
            $gambar_peristiwa = $model->select('gambar_peristiwa')->where('id', $id)->first();
            $data = [
                "peristiwa" => $this->request->getPost('peristiwa'),
                "nama_lokasi" => $this->request->getPost('nama_lokasi'),
                "detail" => $this->request->getPost('detail'),
                "garis_lintang" => $this->request->getPost('garis_lintang'),
                "garis_bujur" => $this->request->getPost('garis_bujur'),
                'gambar_peristiwa' => $gambar_peristiwa,
            ];
        }

        
        $model->update($id, $data);

        return redirect()->to(base_url('admin_daftar_lb'));
        
    }
    public function editViewLaporanBencana($id){
        $model = new LaporanBencanaModel();
        return view('admin_edit_lb', [
            "data" => $model->find($id),
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function editUpdateUser($id){

        // Validasi aturan buku.
        if(!$this->validate('aturanUser')){
            return redirect()->back()->withInput();
        }

        $data = [
            "username" => $this->request->getPost('username'),
            "email" => $this->request->getPost('email'),
            "garis_lintang" => $this->request->getPost('garis_lintang'),
            "garis_bujur" => $this->request->getPost('garis_bujur')
        ];

        $model = new UserModel();
        $model->update($id, $data);
        return redirect()->to(base_url('admin_daftar_user'));
        
    }
    public function editViewUser($id){
        $model = new UserModel();
        return view('admin_edit_user', [
            "data" => $model->find($id),
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

}
