<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $fillabel = [
        'nama_dosen', 'nidn', 'nip', 'gender', 'jurusan_id', 'prodi_id', 'email', 'password', 'image', 'status_dosen'
    ];
    protected $table = 'dosen';
}
