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
    protected $primaryKey = 'id_dosen';
    
    public function jurusan(){
        return $this->belongsTo(Jurusan::class, 'jurusan_id','id_jurusan');
    }

    public function prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id','id_prodi');
    }
}
