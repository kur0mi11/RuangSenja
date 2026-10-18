<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKebutuhan extends Model
{
    protected $table = 'kategori_kebutuhan';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function kebutuhanPanti(): HasMany
    {
        return $this->hasMany(KebutuhanPanti::class, 'kategori_id');
    }
}
