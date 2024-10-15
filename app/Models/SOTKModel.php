<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SOTKModel extends Model
{
    use HasFactory;

    protected $table = 'SOTK';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'image',
        'jabatan',
    ];
}
