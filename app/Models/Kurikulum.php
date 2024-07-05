<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kurikulum extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'id_kurikulum', 'kode_kurikulum', 'nama_kurikulum', 'tahun', 'prodi_id', 'status_kurikulum'
    ];
    public $timestamps = false;
    protected $table = 'kurikulum';
    protected $primaryKey = 'id_kurikulum';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logUnguarded();
        // Chain fluent methods for configuration options
    }

    public function r_prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id','id_prodi');
    }
}
