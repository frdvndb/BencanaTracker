<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeliPremiumModel;
use App\Models\LaporanBencanaModel;
use App\Models\LaporkanLaporanModel;
use App\Models\RelawanModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $helpers = ['form'];
    public function daftarLaporanBencana()
    {
        $model = new LaporanBencanaModel();
    
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $query = $this->request->getVar('query');
    
        if ($query) {
            $model->groupStart()
                ->orLike('histori_laporan.id_user', $query)
                ->orLike('histori_laporan.id_laporan', $query)
                ->orLike('laporan_bencana.peristiwa', $query)
                ->orLike('laporan_bencana.nama_lokasi', $query)
                ->groupEnd();
        }
    
        $data = [
            'data' => $model->select('laporan_bencana.*, histori_laporan.*')
                            ->join('histori_laporan', 'laporan_bencana.id = histori_laporan.id_laporan', 'left')
                            ->paginate(10),
            'pager' => $model->pager,
            'currentPage' => $currentPage,
            'query' => $query,
            'username' => session()->get('username'),
            'isAdmin' => session()->get('isAdmin')
        ];
    
        return view("admin_daftar_lb", $data);
    }
    

    public function daftarUser()
    {
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $query = $this->request->getVar('query');
        $model = new UserModel();

        if ($query) {
            $model->groupStart()
                ->orLike('user.username', $query)
                ->orLike('user.email', $query)
                ->orLike('user.nomor_hp', $query)
                ->orLike('user.garis_lintang', $query)
                ->orLike('user.garis_bujur', $query)
                ->groupEnd();
        }

        return view("admin_daftar_user", [
            'data' => $model->paginate(10),
            'pager' => $model->pager,
            'currentPage' => $currentPage,
            'query' => $query,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function daftarPelaporanLaporan()
    {
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $query = $this->request->getVar('query');

        $model = new LaporkanLaporanModel();

        if ($query) {
            $model->groupStart()
                ->orLike('laporan_pelaporan.id_pelapor_bencana', $query)
                ->orLike('laporan_pelaporan.id_pelapor_laporan', $query)
                ->orLike('laporan_pelaporan.alasan', $query)
                ->groupEnd();
        }

        return view("admin_daftar_pelaporan", [
            'data' => $model->paginate(10),
            'pager' => $model->pager,
            'currentPage' => $currentPage,
            'query' => $query,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function daftarRelawan()
    {
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $query = $this->request->getVar('query');
        $model = new RelawanModel();
        if ($query) {
            $model->groupStart()
                ->orLike('relawan.nama', $query)
                ->orLike('relawan.jenis_bencana', $query)
                ->orLike('relawan.email', $query)
                ->orLike('relawan.no_hp', $query)
                ->groupEnd();
        }
        return view("admin_daftar_relawan", [
            'data' => $model->paginate(10),
            'pager' => $model->pager,
            'currentPage' => $currentPage,
            'query' => $query,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function daftarPembelian()
    {
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
        $query = $this->request->getVar('query');
        $model = new BeliPremiumModel();
        if ($query) {
            $model->groupStart()
                ->orLike('pembelian_premium.id_user', $query)
                ->orLike('pembelian_premium.jumlah_bulan', $query)
                ->orLike('user.tanggal_premium', $query)
                ->groupEnd();
        }
        return view("admin_daftar_pembelian", [
            'data' => $model->select('pembelian_premium.*, user.tanggal_premium, user.username')
            ->join('user', 'pembelian_premium.id_user = user.id', 'left')
            ->paginate(10),
            'pager' => $model->pager,
            'currentPage' => $currentPage,
            'query' => $query,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function deletePembelian($id){
        $model = new BeliPremiumModel();
        $model->delete($id);
        return redirect()->to(base_url('admin_daftar_pembelian'));
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

    public function deleteRelawan($id){
        $model = new RelawanModel();
        $model->delete($id);
        return redirect()->to(base_url('admin_daftar_relawan'));
    }

    public function verifikasiRelawan($id){
        $model = new RelawanModel();
        $relawan = $model->find($id);
        if ($relawan['diverifikasi'] == 0){
            $data = [
                "diverifikasi" => 1,
            ];
        } else {
            $data = [
                "diverifikasi" => 0,
            ];
        }
        $model->update($id, $data);
        return redirect()->to(base_url('admin_daftar_relawan'));
    }

    public function verifikasiLaporanBencana($id){
        $model = new LaporanBencanaModel();
        $laporan = $model->find($id);
        if ($laporan['trusted'] == 0){
            $data = [
                "trusted" => 1,
            ];
        } else {
            $data = [
                "trusted" => 0,
            ];
        }
        $model->update($id, $data);
        return redirect()->to(base_url('admin_daftar_lb'));
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
            "nomor_hp" => $this->request->getPost('nomor_hp'),
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

    public function editUpdateRelawan($id){

        // Validasi aturan buku.
        if(!$this->validate('aturanRelawan')){
            return redirect()->back()->withInput();
        }
        $model = new RelawanModel();
        $gambar_relawan = $this->request->getFile('gambar_relawan');
        if ($gambar_relawan->getSize() > 0) {
            
            $fileData = file_get_contents($gambar_relawan->getTempName());
            $data = [
                "nama" => $this->request->getPost('nama'),
                "jenis_bencana" => $this->request->getPost('jenis_bencana'),
                "detail" => $this->request->getPost('detail'),
                "no_hp" => $this->request->getPost('no_hp'),
                "email" => $this->request->getPost('email'),
                'gambar_relawan' => $fileData,
            ];
        } else {
            $gambar_relawan = $model->select('gambar_relawan')->where('id', $id)->first();
            $data = [
                "nama" => $this->request->getPost('nama'),
                "jenis_bencana" => $this->request->getPost('jenis_bencana'),
                "detail" => $this->request->getPost('detail'),
                "no_hp" => $this->request->getPost('no_hp'),
                "email" => $this->request->getPost('email'),
                'gambar_relawan' => $gambar_relawan,
            ];
        }
        $model->update($id, $data);
        return redirect()->to(base_url('admin_daftar_relawan'));
    }
    
    public function editViewRelawan($id){
        $model = new RelawanModel();
        return view('admin_edit_relawan', [
            "data" => $model->find($id),
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function submitVerifikasiPembelian($id){

        $model = new UserModel();
        $data = [
            "tanggal_premium" => $this->request->getPost('tanggal_premium'),
        ];

        $model->update($id, $data);
        return redirect()->to(base_url('admin_daftar_pembelian'));
    }

    public function batalkanVerifikasiPembelian($id){

        $model = new UserModel();
        $data = [
            "tanggal_premium" => '0000-00-00',
        ];

        $model->update($id, $data);
        return redirect()->to(base_url('admin_daftar_pembelian'));
    }
    
    public function viewVerifikasiPembelian($id){
        $model = new BeliPremiumModel();
        return view('admin_edit_pembelian', [
            'data' => $model->select('pembelian_premium.*, user.tanggal_premium, user.username')
            ->join('user', 'pembelian_premium.id_user = user.id', 'left')
            ->where('pembelian_premium.id', $id)
            ->first(),
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }
}