<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerRpsUas extends Model
{
    use HasFactory, LogsActivity;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('VerRpsUas')
            ->dontSubmitEmptyLogs();
    }

    public function r_pengurus(){
        return $this->belongsTo(Pengurus_kbk::class, 'pengurus_id','id_pengurus');
    }

    public function r_rep_rps_uas(){
        return $this->belongsTo(RepRpsUas::class, 'rep_rps_uas_id','id_rep_rps_uas');
    }
    
    public function p_VerBeritaAcara()
    {
        return $this->belongsToMany(VerBeritaAcara::class, 'ver_berita_acara_detail_pivot', 'ver_rps_uas_id', 'berita_acara_id');
    }
}
