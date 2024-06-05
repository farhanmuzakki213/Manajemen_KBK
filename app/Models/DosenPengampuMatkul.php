<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPengampuMatkul extends Model
{
    use HasFactory;
    protected $fillabel=['dosen_id', 'smt_thnakd_id'];
    protected $table = 'dosen_matkul';
    protected $primaryKey = 'id_dosen_matkul';

    public function matkuls()
    {
        return $this->belongsToMany(Matkul::class, 'dosen_matkul_detail_pivot', 'dosen_matkul_id', 'matkul_id');
    }

    public function kelass()
    {
        return $this->belongsToMany(Kelas::class, 'dosen_matkul_detail_pivot', 'dosen_matkul_id', 'kelas_id');
    }

    public function dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }

    public function smt_thnakd(){
        return $this->belongsTo(ThnAkademik::class, 'smt_thnakd_id','id_smt_thnakd');
    }
}
