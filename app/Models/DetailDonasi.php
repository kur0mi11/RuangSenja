<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailDonasi extends Model
{
    protected $table = 'detail_donasi';

    protected $fillable = [
        'donasi_id',
        'kebutuhan_id',
        'jumlah',
        'satuan',
        'catatan_item',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'decimal:2',
        ];
    }

    public function donasi(): BelongsTo
    {
        return $this->belongsTo(Donasi::class, 'donasi_id');
    }

    public function kebutuhan(): BelongsTo
    {
        return $this->belongsTo(KebutuhanPanti::class, 'kebutuhan_id');
    }
}