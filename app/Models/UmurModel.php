<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmurModel extends Model
{
    use HasFactory;
    protected $table = 'umur';
    public $timestamps = false;


    protected $fillable = [
        'umur',
        'jumlah',
    ];
}
