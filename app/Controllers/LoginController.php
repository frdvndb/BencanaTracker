<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
class LoginController extends BaseController
{
    protected $helpers = ['form'];
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }
    
        $data = [
            "email" => $this->request->getPost('email'),
            "password" => $this->request->getPost('password')
        ];
    
        $model = new UserModel();
        $user = $model->where("email", $data['email'])->first();
    
        if ($user) {
            if (password_verify($data['password'], $user['password'])) {
                session()->set([
                    "username" => $user['username'],
                    'logged_in' => true
                ]);
                return redirect()->to(base_url('/'));
            } else {
                return redirect()->to(base_url('/login'))->with("pesan", "Password1 atau Email Salah");
            }
        } else {
            return redirect()->to(base_url('/login'))->with("pesan", "Password2 atau Email Salah");
        }
    }
    
    public function logout() {
        session()->remove('username');
        session()->remove('logged_in');
        


    
        // Redirect to the login page or any other desired page
        return redirect()->to(base_url('/login'));
    }
    
    
    
}
