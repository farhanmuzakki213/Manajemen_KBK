<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RPSModel extends Model
{
    use HasFactory;
    protected $fillable = ['status_ver_rps','catatan'];
    protected $table = 'ver_rps';
    public $timestamps = true;
}
