<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KebutuhanPanti extends Model
{
    protected $table = 'kebutuhan_panti';

    protected $fillable = [
        'kategori_id',
        'dibuat_oleh',
        'nama_kebutuhan',
        'deskripsi',
        'jumlah_dibutuhkan',
        'satuan',
        'prioritas',
        'status_kebutuhan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_dibutuhkan' => 'decimal:2',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriKebutuhan::class, 'kategori_id');
    }

    public function detailDonasi(): HasMany
    {
        return $this->hasMany(DetailDonasi::class, 'kebutuhan_id');
    }
}
