<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VerBeritaAcaraDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'berita_acara_id',
        'ver_rps_uas_id',
        'jenis_kbk_id',
    ];
    protected $table = 'ver_berita_acara_detail_pivot';
    protected $primaryKey = 'berita_acara_id';
    public $timestamps = false;
    public function p_ver_rps_uas(): BelongsToMany
    {
        return $this->belongsToMany(VerRpsUas::class, 'ver_berita_acara_detail_pivot', 'berita_acara_id', 'ver_rps_uas_id');
    }
}
