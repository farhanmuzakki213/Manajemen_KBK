<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanKbk extends Model
{
    use HasFactory;
    protected $fillabel = [
        'jabatan', 'deskripsi'
    ];
    protected $table = 'jabatan_kbk';
}
