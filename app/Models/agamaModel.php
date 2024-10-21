<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agamaModel extends Model
{
    use HasFactory;
    protected $table = 'agama';
    public $timestamps = false;
    protected $fillable = [
        'nama_agama',
        'jumlah_penganut',
    ];
}
