<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerBeritaAcara extends Model
{
    use HasFactory;
    protected $table = 'ver_berita_acara';
    protected $primaryKey = 'id_berita_acara';

    public function p_ver_rps_uas()
    {
        return $this->belongsToMany(VerRpsUas::class, 'ver_berita_acara_detail_pivot', 'berita_acara_id', 'ver_rps_uas_id');
    }

    public function p_prodi()
    {
        return $this->belongsToMany(Prodi::class, 'ver_berita_acara_detail_pivot', 'berita_acara_id', 'prodi_id');
    }
}
