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
     * Tabel kebutuhan_panti menyimpan daftar kebutuhan yang ditampilkan kepada donatur.
     * FK ke: kategori_kebutuhan, pengguna (admin pembuat).
     */
    public function up(): void
    {
        Schema::create('kebutuhan_panti', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_id')
                ->constrained('kategori_kebutuhan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('dibuat_oleh')
                ->nullable()
                ->constrained('pengguna')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('nama_kebutuhan', 150);
            $table->text('deskripsi')->nullable();
            $table->decimal('jumlah_dibutuhkan', 12, 2);
            $table->string('satuan', 30);
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->enum('status_kebutuhan', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->index('kategori_id', 'idx_kebutuhan_kategori');
            $table->index('status_kebutuhan', 'idx_kebutuhan_status');
            $table->index('dibuat_oleh', 'idx_kebutuhan_admin');
        });

        DB::statement('ALTER TABLE kebutuhan_panti ADD CONSTRAINT chk_kebutuhan_jumlah CHECK (jumlah_dibutuhkan > 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebutuhan_panti');
    }
};
