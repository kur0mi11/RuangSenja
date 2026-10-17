<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel donasi menyimpan pengajuan donasi dari donatur.
     * FK ke: pengguna (donatur_id dan diproses_oleh).
     */
    public function up(): void
    {
        Schema::create('donasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_donasi', 30)->unique();

            $table->foreignId('donatur_id')
                ->constrained('pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->enum('tipe_donasi', ['barang', 'uang']);
            $table->decimal('nominal', 14, 2)->nullable();
            $table->enum('metode_donasi', ['langsung', 'transfer', 'pengiriman'])->default('langsung');
            $table->string('bukti_transfer', 255)->nullable();
            $table->text('catatan_donatur')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->text('catatan_admin')->nullable();

            $table->foreignId('diproses_oleh')
                ->nullable()
                ->constrained('pengguna')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->dateTime('diproses_pada')->nullable();
            $table->timestamps();

            $table->index(['donatur_id', 'status'], 'idx_donasi_donatur_status');
            $table->index('status', 'idx_donasi_status');
            $table->index('diproses_oleh', 'idx_donasi_diproses_oleh');
            $table->index('created_at', 'idx_donasi_tanggal');
        });

        DB::statement("
            ALTER TABLE donasi
            ADD CONSTRAINT chk_donasi_nominal
            CHECK (
                (tipe_donasi = 'uang'   AND nominal IS NOT NULL AND nominal > 0)
                OR
                (tipe_donasi = 'barang' AND nominal IS NULL)
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};
