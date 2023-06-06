<?php

namespace App\Models;

use CodeIgniter\Model;

// Pembuatan kelas sebagai model
class MahasiswaModel extends Model
{
    // tes andra mempush mid
    // Pembuatan variabel
    protected $nama = 'M. Farid Pebrian';
    protected $nim = '2110817210015';
    protected $gambarProfil = 'assets/img/profile.jpg';
    protected $prodi = 'Teknologi Informasi';
    protected $hobi = 'Membaca Novel';
    protected $skill = 'Gaming';
    protected $github = 'https://github.com/frdvndb';
    protected $gambarBackground = 'assets/img/background.jpg';

    // Pembuatan getter
    public function getNama() 
    {
        return $this->nama;
    }

    public function getNim() 
    {
        return $this->nim;
    }

    public function getGambarProfil() 
    {
        return $this->gambarProfil;
    }

    public function getProdi() 
    {
        return $this->prodi;
    }

    public function getHobi() 
    {
        return $this->hobi;
    }

    public function getSkill() 
    {
        return $this->skill;
    }

    public function getGithub() 
    {
        return $this->github;
    }

    public function getGambarBackground() 
    {
        return $this->gambarBackground;
    }
}