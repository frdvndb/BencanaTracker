<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
class RegisterController extends BaseController
{
    protected $helpers = ['form'];
    public function index()
    {
        return view("register");
    }

    public function buat()
    {
        $rules = [
            'username' => 'required',
            'email' => 'required|max_length[100]',
            'password' => 'required|max_length[100]'
        ];
        if(!$this->validate($rules)){
            return redirect()->back()->withInput();
        }
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $garis_lintang = $this->request->getPost('latitude');
        $garis_bujur = $this->request->getPost('longitude');
        $nomor_hp = $this->request->getPost('nomor_hp');

        $model = new UserModel();
        $model->insert([
            "username" => $username,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            'garis_lintang' => $garis_lintang,
            'garis_bujur' => $garis_bujur,
            'nomor_hp' => $nomor_hp
        ]);
        session()->setFlashdata('success', 'Berhasil Membuat Akun.');
        return redirect()->to(base_url('/login'));
    }
}
