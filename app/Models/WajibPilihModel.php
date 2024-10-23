<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WajibPilihModel extends Model
{
    use HasFactory;
    protected $table = 'wajib_pilih';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'wajib_pilih'
    ];
}
