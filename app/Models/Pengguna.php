<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel sesuai migration.
     */
    protected $table = 'pengguna';

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'nama',
        'email',
        'password_hash',
        'no_hp',
        'alamat',
        'role',
        'status_akun',
    ];

    /**
     * Kolom yang disembunyikan dari serialisasi.
     */
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    /**
     * Laravel Auth mengharapkan kolom 'password', sedangkan
     * tabel kita menggunakan 'password_hash'.
     */
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function getAuthPasswordName(): string {
        return 'password_hash';
    }

    /**
     * Setter agar assignment pada key 'password' otomatis mengisi 'password_hash'.
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password_hash'] = bcrypt($value);
    }

    /**
     * Periksa apakah pengguna memiliki peran admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Periksa apakah pengguna memiliki peran donatur.
     */
    public function isDonatur(): bool
    {
        return $this->role === 'donatur';
    }

    /**
     * Periksa apakah akun berstatus aktif.
     */
    public function isAktif(): bool
    {
        return $this->status_akun === 'aktif';
    }
}
