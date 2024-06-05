<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepRpsUas extends Model
{
    use HasFactory;
    protected $fillable = ['id_rep_rps_uas', 'smt_thnakd_id', 'dosen_id', 'matkul_id', 'type', 'file'];


    protected $table = 'rep_rps_uas';
    public $incrementing = false;
    protected $primaryKey = 'id_ver_rps_uas';
    public $timestamps = true;

    public function dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }

    public function matkul(){
        return $this->belongsTo(Matkul::class, 'matkul_id','id_matkul');
    }

    public function smt_thnakd(){
        return $this->belongsTo(ThnAkademik::class, 'smt_thnakd_id','id_smt_thnakd');
    }
    
}
