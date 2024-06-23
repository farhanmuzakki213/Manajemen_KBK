<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_kurikulum', 'kode_kurikulum', 'nama_kurikulum', 'tahun', 'prodi_id', 'status_kurikulum'
    ];
    public $timestamps = false;
    protected $table = 'kurikulum';
    protected $primaryKey = 'id_kurikulum';

    public function r_prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id','id_prodi');
    }
}
