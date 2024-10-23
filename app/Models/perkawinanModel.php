<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perkawinanModel extends Model
{
    use HasFactory;

    protected $table = 'perkawinan';
    public $timestamps = false;

    protected $fillable = [
        'belum_kawin',
        'kawin',
        'cerai_mati',
        'cerai_hidup'
    ];
}
