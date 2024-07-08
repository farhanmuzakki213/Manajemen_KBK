<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengurus_kbk extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['id_pengurus','jenis_kbk_id', 'dosen_id', 'jabatan_kbk_id','status_pengurus_kbk'];
    protected $table = 'pengurus_kbk';
    public $timestamps = false;
    protected $primaryKey = 'id_pengurus';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Pengurus_kbk')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName} PengurusKbk";
            });
    }

    public function r_dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }

    public function r_jenis_kbk(){
        return $this->belongsTo(JenisKbk::class, 'jenis_kbk_id','id_jenis_kbk');
    }

    public function r_jabatan_kbk(){
        return $this->belongsTo(JabatanKbk::class, 'jabatan_kbk_id','id_jabatan_kbk');
    }    
}
