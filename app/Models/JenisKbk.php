<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKbk extends Model
{
    use HasFactory;
    protected $fillable = ['jenis_kbk', 'deskripsi'];
    protected $table = 'jenis_kbk';
    public $timestamps = false;
}
