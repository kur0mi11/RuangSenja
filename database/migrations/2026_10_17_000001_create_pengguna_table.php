<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel pengguna menyimpan akun admin dan donatur.
     */
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 150)->unique();
            $table->string('password_hash', 255);
            $table->rememberToken();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->enum('role', ['admin', 'donatur'])->default('donatur');
            $table->enum('status_akun', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->index('role', 'idx_pengguna_role');
            $table->index('status_akun', 'idx_pengguna_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
