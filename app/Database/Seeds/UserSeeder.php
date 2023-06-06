<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;
class UserSeeder extends Seeder
{
    public function run()
    {
        $model = new UserModel();
        $model->insert([
            "username" => "user",
            "email" => "user@gmail.com",
            "password" => password_hash("user", PASSWORD_DEFAULT)
        ]);
    }
}
