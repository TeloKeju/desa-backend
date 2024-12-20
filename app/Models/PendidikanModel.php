<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendidikanModel extends Model
{
    use HasFactory;
    protected $table = 'pendidikan';
    public $timestamps = false;
    protected $fillable = [
        'jenis_pendidikan',
        'jumlah',
    ];
}
