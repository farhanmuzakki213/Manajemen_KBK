<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prodi extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = ['id_prodi','kode_prodi', 'prodi', 'jurusan_id', 'jenjang'];
    protected $table = 'prodi';
    protected $primaryKey = 'id_prodi';
    public $timestamps = false;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logUnguarded();
        // Chain fluent methods for configuration options
    }

    public function r_jurusan(){
        return $this->belongsTo(Jurusan::class, 'jurusan_id','id_jurusan');
    }

    public function p_VerBeritaAcara()
    {
        return $this->belongsToMany(VerBeritaAcara::class, 'ver_berita_acara_detail_pivot', 'prodi_id', 'berita_acara_id');
    }
}
