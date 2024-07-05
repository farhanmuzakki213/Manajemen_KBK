<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DosenPengampuMatkul extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable= ['id_dosen_matkul','dosen_id','smt_thnakd_id'];
    protected $table = 'dosen_matkul';
    public $timestamps = false;
    protected $primaryKey = 'id_dosen_matkul';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('DosenPengampuMatkul')
            ->dontSubmitEmptyLogs();
    }

    public function p_matkulKbk(): BelongsToMany
    {
        return $this->belongsToMany(
            MatkulKBK::class,
            'dosen_matkul_detail_pivot',
            'dosen_matkul_id',
            'matkul_kbk_id'
        )->withPivot('kelas_id');
    }

    public function p_kelas(): BelongsToMany
    {
        return $this->belongsToMany(
            Kelas::class,
            'dosen_matkul_detail_pivot',
            'dosen_matkul_id',
            'kelas_id'
        );
    }

    public function r_dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen');
    }

    public function r_smt_thnakd(){
        return $this->belongsTo(ThnAkademik::class, 'smt_thnakd_id','id_smt_thnakd');
    }
}
