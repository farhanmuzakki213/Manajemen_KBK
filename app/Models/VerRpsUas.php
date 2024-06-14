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
        'pengurus_id',
        'rekomendasi',
        'saran',
        'tanggal_diverifikasi',
    ];

    protected $table = 'ver_rps_uas';
    public $timestamps = false;

    protected $primaryKey = 'id_ver_rps_uas';
    public $incrementing = false;

    public function r_pengurus(){
        return $this->belongsTo(Pengurus_kbk::class, 'pengurus_id','id_pengurus');
    }

    public function r_rep_rps_uas(){
        return $this->belongsTo(RepRpsUas::class, 'rep_rps_uas_id','id_rep_rps_uas');
    }
    
    public function p_VerBeritaAcara()
    {
        return $this->belongsToMany(VerBeritaAcara::class, 'ver_berita_acara_detail_pivot', 'rep_rps_uas_id', 'berita_acara_id');
    }
}
