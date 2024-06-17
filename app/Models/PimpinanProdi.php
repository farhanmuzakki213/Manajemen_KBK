<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PimpinanProdi extends Model
{
    use HasFactory;
    protected $fillable = ['id_pimpinan_prodi','jabatan_pimpinan_id','prodi_id','dosen_id','periode', 'status_pimpinan_prodi'];
    protected $table = 'pimpinan_prodi';
    public $timestamps = false;
    protected $primaryKey = 'id_pimpinan_prodi';

    public function r_jabatan_pimpinan(){
        return $this->belongsTo(JabatanPimpinan::class, 'jabatan_pimpinan_id','id_jabatan_pimpinan');
    }

    public function r_prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id','id_prodi');
    }

    public function r_dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }

}
