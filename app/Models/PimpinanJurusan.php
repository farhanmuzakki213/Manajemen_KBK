<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PimpinanJurusan extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['id_pimpinan_jurusan','jabatan_pimpinan_id','jurusan_id','dosen_id','periode', 'status_pimpinan_jurusan'];
    protected $table = 'pimpinan_jurusan';
    public $timestamps = false;
    protected $primaryKey = 'id_pimpinan_jurusan';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('PimpinanJurusan')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName} PimpinanJurusan";
            });
    }

    public function r_dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }

    public function r_jurusan(){
        return $this->belongsTo(Jurusan::class, 'jurusan_id','id_jurusan');
    }

    public function r_jabatan_pimpinan(){
        return $this->belongsTo(JabatanPimpinan::class, 'jabatan_pimpinan_id','id_jabatan_pimpinan');
    }
}
