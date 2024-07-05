<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Kelas')
            ->dontSubmitEmptyLogs();
    }

    public function p_dosenPengampuMatkul()
    {
        return $this->belongsToMany(DosenPengampuMatkul::class, 'dosen_matkul_detail_pivot', 'kelas_id', 'dosen_matkul_id');
    }
    
    public function r_prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id','id_prodi');
    }

    public function r_smt_thnakd(){
        return $this->belongsTo(ThnAkademik::class, 'smt_thnakd_id','id_smt_thnakd');
    }
}
