<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepRpsUas extends Model
{
    use HasFactory;
    protected $fillable = ['id_rep_rps_uas', 'smt_thnakd_id', 'dosen_matkul_id', 'matkul_kbk_id', 'type', 'file'];


    protected $table = 'rep_rps_uas';
    public $incrementing = false;
    protected $primaryKey = 'id_ver_rps_uas';
    public $timestamps = true;

    public function r_dosen_matkul(){
        return $this->belongsTo(DosenPengampuMatkul::class, 'dosen_matkul_id','id_dosen_matkul');
    }

    public function r_matkulKbk(){
        return $this->belongsTo(MatkulKBK::class, 'matkul_kbk_id','id_matkul_kbk');
    }

    public function r_smt_thnakd(){
        return $this->belongsTo(ThnAkademik::class, 'smt_thnakd_id','id_smt_thnakd');
    }
    
}
