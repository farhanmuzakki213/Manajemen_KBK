<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    public function dosenPengampuMatkuls()
    {
        return $this->belongsToMany(DosenPengampuMatkul::class, 'dosen_matkul_detail_pivot', 'kelas_id', 'dosen_matkul_id');
    }
    
    public function prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id','id_prodi');
    }
}
