<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lansia extends Model
{
    protected $table = 'lansia';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'nomor_kamar',
        'tanggal_masuk',
        'keterangan',
        'foto',
        'status_penghuni',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tanggal_masuk' => 'date',
        ];
    }
}