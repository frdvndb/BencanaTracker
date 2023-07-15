<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeliPremiumModel;
use App\Models\NotifikasiLaporanModel;
use App\Models\UserModel;

class NotifikasiLaporanController extends BaseController
{
    public function index()
    {
        $model = new NotifikasiLaporanModel();

        $userModel = new UserModel();
    
        $id = session()->get('id');

        $lokasiUser = $userModel->select('garis_lintang, garis_bujur')->where('id', $id)->first();

        $emailSub = $userModel->select('email_subscribe')->where('id', $id)->first();
        $pushSub = $userModel->select('push_subscribe')->where('id', $id)->first();
        $radiusNotif = $userModel->select('radius_notif')->where('id', $id)->first();
        $tanggalPremium = $userModel->select('tanggal_premium')->where('id', $id)->first();

        if ($radiusNotif == null) {
            $radiusNotif = 5;
        }

        date_default_timezone_set('Asia/Makassar');

        // Mengambil waktu 1 minggu yang lalu
        $oneWeekAgo = date('Y-m-d', strtotime('-1 week'));

        $data = $model->select('notifikasi_laporan.*, laporan_bencana.*')
            ->join('laporan_bencana', 'laporan_bencana.id = notifikasi_laporan.id_laporan')
            ->where('notifikasi_laporan.id_user', $id)
            ->where('laporan_bencana.tanggal >=', $oneWeekAgo) // Hanya ambil laporan yang dibuat 1 minggu yang lalu atau kurang
            ->findAll();  
              
        return view('notifikasi', [
            "lokasiUser" => $lokasiUser,
            "radiusNotif" => $radiusNotif,
            "userID" => $id,
            "data" => $data,
            "emailSub" => $emailSub,
            "pushSub" => $pushSub,
            'tanggalPremium' => $tanggalPremium,
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function beliPremium()
    {
        // session()->setFlashdata('success', 'Tunggu Diverifikasi Admin! Kemungkinkan 1-10 hari!.');
        session()->setFlashdata('failed', 'Beli premium untuk membantu pengembang!');
        return view('beli_premium',[
            "username" => session()->get('username'),
            "isAdmin" => session()->get('isAdmin')
        ]);
    }

    public function submitBeliPremium()
    {
        date_default_timezone_set('Asia/Makassar');
        $buktiPembayaran = $this->request->getFile('bukti_pembayaran');
        $fileData = file_get_contents($buktiPembayaran->getTempName());
        $model = new BeliPremiumModel();
        $model->insert([
            'id_user' => session()->get('id'),
            'jumlah_bulan' => $this->request->getPost('jumlah_bulan'),
            'bukti_pembayaran' => $fileData,
            'waktu_pembelian'=> date('Y-m-d H:i:s')
        ]);
        session()->setFlashdata('successBeli', 'Tunggu Diverifikasi Admin! Kemungkinkan 1-7 hari!');
        return redirect()->to(base_url('notifikasi'));
    }

    public function updateLokasiUser()
    {
        $model = new UserModel();
    
        $id = session()->get('id');
    
        // Ambil data lokasi yang dikirim dari request
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
    
        // Update lokasi user di database
        $data = [
            'garis_lintang' => $latitude,
            'garis_bujur' => $longitude
        ];
        $model->update($id, $data);
    
        session()->setFlashdata('success', 'Berhasil Memperbarui Lokasi.');
        return $this->response->setJSON(['success' => true]);
    }
    public function updateStatusLangganan() 
    {
        $model = new UserModel();
    
        $id = session()->get('id');
    
        // Ambil data status langganan yang dikirim dari request
        if ($this->request->getPost('type') == 'email' && $this->request->getPost('value') == 'true') {
            $data = [
                'email_subscribe' => 1
            ];
            $model->update($id, $data);

            session()->setFlashdata('success', 'Berhasil Memperbarui Status Langganan.');
            return $this->response->setJSON(['success' => true]);    
        } else if ($this->request->getPost('type') == 'email' && $this->request->getPost('value') == 'false') {
            $data = [
                'email_subscribe' => 0
            ];
            $model->update($id, $data);

            session()->setFlashdata('success', 'Berhasil Memperbarui Status Langganan.');
            return $this->response->setJSON(['success' => true]);    
        }
        
        if ($this->request->getPost('type') == 'push' && $this->request->getPost('value') == 'true') {
            $data = [
                'push_subscribe' => 1
            ];
            $model->update($id, $data);

            session()->setFlashdata('success', 'Berhasil Memperbarui Status Langganan.');
            return $this->response->setJSON(['success' => true]);    
        } else if ($this->request->getPost('type') == 'push' && $this->request->getPost('value') == 'false') {
            $data = [
                'push_subscribe' => 0
            ];
            $model->update($id, $data);

            session()->setFlashdata('success', 'Berhasil Memperbarui Status Langganan.');
            return $this->response->setJSON(['success' => true]);    
        }
    }    
    public function updateRadius()
    {
        $model = new UserModel();
        $id = session()->get('id');
        $data = [
            'radius_notif' => $this->request->getPost('radius')
        ];
        $model->update($id, $data);
        
        session()->setFlashdata('success', 'Berhasil Memperbarui Radius Notifikasi');
        return $this->response->setJSON(['success' => true]);    
    }
}