<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DosenPengampuMatkul extends Model
{
    use HasFactory, LogsActivity;
    protected $fillabel=['dosen_id', 'smt_thnakd_id'];
    protected $table = 'dosen_matkul';
    protected $primaryKey = 'id_dosen_matkul';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('DosenPengampuMatkul')
            ->dontSubmitEmptyLogs();
    }

    public function p_matkulKbk()
    {
        return $this->belongsToMany(MatkulKBK::class, 'dosen_matkul_detail_pivot', 'dosen_matkul_id', 'matkul_kbk_id');
    }

    public function p_kelas()
    {
        return $this->belongsToMany(Kelas::class, 'dosen_matkul_detail_pivot', 'dosen_matkul_id', 'kelas_id');
    }

    public function r_dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }

    public function r_smt_thnakd(){
        return $this->belongsTo(ThnAkademik::class, 'smt_thnakd_id','id_smt_thnakd');
    }
}
