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

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'dibuat_oleh');
    }

    public function detailDonasi(): HasMany
    {
        return $this->hasMany(DetailDonasi::class, 'kebutuhan_id');
    }

    /**
     * Hitung jumlah yang sudah terpenuhi berdasarkan detail donasi berstatus Diterima.
     */
    public function jumlahTerpenuhi(): float
    {
        return (float) $this->detailDonasi()
            ->whereHas('donasi', fn ($q) => $q->where('status', 'diterima'))
            ->sum('jumlah');
    }

    /**
     * Cek apakah kebutuhan memiliki pengajuan yang masih Menunggu.
     */
    public function punyaPengajuanMenunggu(): bool
    {
        return $this->detailDonasi()
            ->whereHas('donasi', fn ($q) => $q->where('status', 'menunggu'))
            ->exists();
    }
}
