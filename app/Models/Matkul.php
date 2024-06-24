<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;
    protected $fillable = ['id_matkul','kode_matkul', 'nama_matkul', 'TP', 'jam', 'sks', 'sks_teori', 'sks_praktek', 'jam_teori', 'jam_praktek', 'semester', 'kurikulum_id'];
    protected $table = 'matkul';
    public $timestamps = false;
    protected $primaryKey = 'id_matkul';

    public function r_kurikulum(){
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id','id_kurikulum');
    }
}
