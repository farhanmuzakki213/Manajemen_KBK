<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VerBeritaAcaraDetail extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'berita_acara_id',
        'ver_rps_uas_id',
    ];
    protected $table = 'ver_berita_acara_detail_pivot';
    protected $primaryKey = 'berita_acara_id';
    public $timestamps = false;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('VerBeritaAcaraDetail')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName} VerBeritaAcaraDetail";
            });
    }

    public function r_ver_rps_uas(){
        return $this->belongsTo(VerRpsUas::class, 'ver_rps_uas_id','id_ver_rps_uas');
    }
}
