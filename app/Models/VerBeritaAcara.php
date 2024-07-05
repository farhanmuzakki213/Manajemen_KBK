<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VerBeritaAcara extends Model
{

    use HasFactory, LogsActivity;
    protected $fillable = [
        'id_berita_acara',
        'kajur',
        'kaprodi',
        'jenis_kbk_id',
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('VerBeritaAcara')
            ->dontSubmitEmptyLogs();
    }

    public function p_ver_rps_uas(): BelongsToMany
    {
        return $this->belongsToMany(VerRpsUas::class, 'ver_berita_acara_detail_pivot', 'berita_acara_id', 'ver_rps_uas_id');
    }

    public function r_pimpinan_prodi()
    {
        return $this->belongsTo(PimpinanProdi::class, 'kajur', 'id_pimpinan_prodi');
    }

    public function r_pimpinan_jurusan()
    {
        return $this->belongsTo(PimpinanJurusan::class, 'kaprodi', 'id_pimpinan_jurusan');
    }

    public function r_jenis_kbk()
    {
        return $this->belongsTo(JenisKbk::class, 'jenis_kbk_id', 'id_jenis_kbk');
    }
}
