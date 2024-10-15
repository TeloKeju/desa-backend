<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleryModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'galery';

    protected $fillable = [
        'id',
        'image',
    ];
}
