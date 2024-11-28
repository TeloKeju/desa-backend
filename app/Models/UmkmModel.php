<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UmkmModel extends Model
{
    use HasFactory;
    protected $table = 'umkm';
    public $timestamps = false;


    protected $fillable = [
        'name',
        'image',
        'description',
        'rating',
        'contact',
        'price'
    ];

    public function comment(): HasMany
    {
        return $this->hasMany(commentModel::class, "umkm_id");
    }

    public function pembelian(): HasMany
    {
        return $this->hasMany(pembelianModel::class, "umkm_id");
    }
}
