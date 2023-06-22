<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanBencanaModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $helpers = ['form'];
    public function daftarLaporanBencana()
    {
        $model = new LaporanBencanaModel();
        return view("admin_daftar_lb", [
            'data' => $model->paginate(10),
            'pager' => $model->pager,
            "username" => session()->get('username')
        ]);
    }

    public function daftarUser()
    {
        $model = new UserModel();
        return view("admin_daftar_user", [
            'data' => $model->paginate(10),
            'pager' => $model->pager,
            "username" => session()->get('username')
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

    public function editUpdateLaporanBencana($id){

        // Validasi aturan buku.
        if(!$this->validate('aturanLaporanBencana')){
            return redirect()->back()->withInput();
        }

        $data = [
            "peristiwa" => $this->request->getPost('peristiwa'),
            "nama_lokasi" => $this->request->getPost('nama_lokasi'),
            "detail" => $this->request->getPost('detail'),
            "garis_lintang" => $this->request->getPost('garis_lintang'),
            "garis_bujur" => $this->request->getPost('garis_bujur')
        ];

        $model = new LaporanBencanaModel();
        $model->update($id, $data);

        return redirect()->to(base_url('admin_daftar_lb'));
        
    }
    public function editViewLaporanBencana($id){
        $model = new LaporanBencanaModel();
        return view('admin_edit_lb', [
            "data" => $model->find($id),
            "username" => session()->get('username')
        ]);
    }

    public function editUpdateUser($id){

        // Validasi aturan buku.
        if(!$this->validate('aturanLaporanBencana')){
            return redirect()->back()->withInput();
        }

        $data = [
            "peristiwa" => $this->request->getPost('peristiwa'),
            "nama_lokasi" => $this->request->getPost('nama_lokasi'),
            "detail" => $this->request->getPost('detail'),
            "garis_lintang" => $this->request->getPost('garis_lintang'),
            "garis_bujur" => $this->request->getPost('garis_bujur')
        ];

        $model = new LaporanBencanaModel();
        $model->update($id, $data);

        return redirect()->to(base_url('admin_daftar_lb'));
        
    }
    public function editViewUser($id){
        $model = new LaporanBencanaModel();
        return view('admin_edit_lb', [
            "data" => $model->find($id),
            "username" => session()->get('username')
        ]);
    }

}
