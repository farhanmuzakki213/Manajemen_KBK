<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matkul extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['id_matkul','kode_matkul', 'nama_matkul', 'TP', 'jam', 'sks', 'sks_teori', 'sks_praktek', 'jam_teori', 'jam_praktek', 'semester', 'kurikulum_id'];
    protected $table = 'matkul';
    public $timestamps = false;
    protected $primaryKey = 'id_matkul';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('Matkul')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function(string $eventName) {
                return "{$eventName} Matkul";
            });
    }

    public function r_kurikulum(){
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id','id_kurikulum');
    }
}
