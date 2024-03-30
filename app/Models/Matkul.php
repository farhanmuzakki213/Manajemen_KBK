<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;
    protected $fillable = ['kode_matkul', 'nama_matkul', 'TP', 'jam', 'sks', 'sks_teori', 'sks_praktek', 'jam_teori', 'jam_praktek', 'semester', 'kurikulum_id'];
    protected $table = 'matkul';
    public $timestamps = false;
}
