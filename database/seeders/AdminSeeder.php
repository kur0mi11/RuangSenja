<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Pengguna::firstOrCreate(
            ['email' => 'admin@ruangsenja.id'],
            [
                'nama'          => 'Admin RuangSenja',
                'password_hash' => Hash::make('Admin@12345'),
                'role'          => 'admin',
                'status_akun'   => 'aktif',
            ]
        );

        $this->command->info('Akun admin berhasil dibuat.');
        $this->command->line('  Email    : admin@ruangsenja.id');
        $this->command->line('  Password : Admin@12345');
        $this->command->warn('  Segera ganti password setelah login pertama!');
    }
}
