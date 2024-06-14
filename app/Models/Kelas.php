<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    public function p_dosenPengampuMatkul()
    {
        return $this->belongsToMany(DosenPengampuMatkul::class, 'dosen_matkul_detail_pivot', 'kelas_id', 'dosen_matkul_id');
    }
    
    public function r_prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id','id_prodi');
    }

    public function r_smt_thnakd(){
        return $this->belongsTo(ThnAkademik::class, 'smt_thnakd_id','id_smt_thnakd');
    }
}
