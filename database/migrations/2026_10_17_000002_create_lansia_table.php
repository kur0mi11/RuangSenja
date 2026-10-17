<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel lansia menyimpan data penghuni panti jompo.
     */
    public function up(): void
    {
        Schema::create('lansia', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 150);
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('nomor_kamar', 30)->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('foto', 255)->nullable();
            $table->enum('status_penghuni', ['aktif', 'pindah', 'meninggal'])->default('aktif');
            $table->timestamps();

            $table->index('nama_lengkap', 'idx_lansia_nama');
            $table->index('status_penghuni', 'idx_lansia_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lansia');
    }
};
