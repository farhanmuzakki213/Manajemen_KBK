<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $fillable = ['id_prodi','kode_prodi','prodi','jurusan_id','jenjang'];
    protected $table = 'prodi';
    protected $primaryKey = 'id_prodi';

    public function r_jurusan(){
        return $this->belongsTo(Jurusan::class, 'jurusan_id','id_jurusan');
    }

    public function p_VerBeritaAcara()
    {
        return $this->belongsToMany(VerBeritaAcara::class, 'ver_berita_acara_detail_pivot', 'prodi_id', 'berita_acara_id');
    }
}
