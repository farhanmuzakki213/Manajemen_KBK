<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class VerRpsUas extends Model
{
    protected $fillable = [
        'id_ver_rps_uas',
        'rep_rps_uas_id',
        'dosen_id',
        'status_verifikasi',
        'rekomendasi',
        'saran',
        'tanggal_diverifikasi',
    ];

    protected $table = 'ver_rps_uas';
    public $timestamps = false;

    protected $primaryKey = 'id_ver_rps_uas';
    public $incrementing = false;

    public function dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }

    public function rep_rps(){
        return $this->belongsTo(RepRpsUas::class, 'rep_rps_uas_id','id_rep_rps_uas');
    }

}
