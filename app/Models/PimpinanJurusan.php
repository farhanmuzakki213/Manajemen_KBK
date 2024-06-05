<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PimpinanJurusan extends Model
{
    use HasFactory;
    protected $fillable = ['id_pimpinan_jurusan','jabatan_pimpinan_id','jurusan_id','dosen_id','periode', 'status_pimpinan_jurusan'];
    protected $table = 'pimpinan_jurusan';
    public $timestamps = false;
    protected $primaryKey = 'id_pimpinan)_jurusan';

    public function dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }

    public function jurusan(){
        return $this->belongsTo(Jurusan::class, 'jurusan_id','id_jurusan');
    }

    public function jabatan_pimpinan(){
        return $this->belongsTo(JabatanPimpinan::class, 'jabatan_pimpinan_id','id_jabatan_pimpinan');
    }
}
