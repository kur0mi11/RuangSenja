<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donasi extends Model
{
    protected $table = 'donasi';

    protected $fillable = [
        'kode_donasi',
        'donatur_id',
        'tipe_donasi',
        'nominal',
        'metode_donasi',
        'bukti_transfer',
        'catatan_donatur',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
            'diproses_pada' => 'datetime',
        ];
    }

    //pengguna yg ngajuin donasi
    public function donatur(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'donatur_id');
    }

    //admin yg proses donasi
    public function diprosesOleh(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'diproses_oleh');
    }

    //rincian barang dalam pengajuan donasi
    public function detailDonasi(): HasMany
    {
        return $this->hasMany(DetailDonasi::class, 'donasi_id');
    }
}