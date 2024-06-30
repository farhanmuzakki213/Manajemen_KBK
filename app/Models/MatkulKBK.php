<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatkulKBK extends Model
{
    use HasFactory;
    protected $fillable = ['id_matkul_kbk','matkul_id','jenis_kbk_id', 'prodi_id', 'kurikulum_id'];
    protected $table = 'matkul_kbk';
    public $timestamps = false;
    protected $primaryKey = 'id_matkul_kbk';

    public function r_kurikulum(){
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id','id_kurikulum');
    }

    public function r_jenis_kbk(){
        return $this->belongsTo(JenisKbk::class, 'jenis_kbk_id','id_jenis_kbk');
    }

    public function r_matkul(){
        return $this->belongsTo(Matkul::class, 'matkul_id','id_matkul');
    }

    public function r_prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id','id_prodi');
    }

    public function p_dosenPengampuMatkul()
    {
        return $this->belongsToMany(DosenPengampuMatkul::class, 'dosen_matkul_detail_pivot', 'matkul_kbk_id', 'dosen_matkul_id');
    }
}
