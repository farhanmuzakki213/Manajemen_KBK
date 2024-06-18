<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VerBeritaAcara extends Model
{

    use HasFactory;
    protected $fillable = [
        'id_berita_acara',
        'kajur',
        'kaprodi',
        'file_berita_acara',
        'Status_dari_kaprodi',
        'tanggal_diverifikasi',
        'Status_dari_kajur',
        'type',
        'tanggal_disetujui_kaprodi',
        'tanggal_diketahui_kajur',
        'tanggal_upload',
    ];
    protected $table = 'ver_berita_acara';
    public $timestamps = false;
    protected $primaryKey = 'id_berita_acara';

    public function p_ver_rps_uas(): BelongsToMany
    {
        return $this->belongsToMany(VerRpsUas::class, 'ver_berita_acara_detail_pivot', 'berita_acara_id', 'ver_rps_uas_id');
    }

    public function p_prodi()
    {
        return $this->belongsToMany(Prodi::class, 'ver_berita_acara_detail_pivot', 'berita_acara_id', 'prodi_id');
    }
}
