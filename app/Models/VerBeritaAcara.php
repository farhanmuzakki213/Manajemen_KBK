<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerBeritaAcara extends Model
{
    use HasFactory;
    protected $table = 'ver_berita_acara';
    protected $primaryKey = 'id_berita_acara';

    public function ver_rps_uas()
    {
        return $this->belongsToMany(Matkul::class, 'ver_berita_acara_detail_pivot', 'berita_acara_id', 'ver_rps_uas_id');
    }

    public function prodi()
    {
        return $this->belongsToMany(Kelas::class, 'ver_berita_acara_detail_pivot', 'berita_acara_id', 'prodi_id');
    }
}
