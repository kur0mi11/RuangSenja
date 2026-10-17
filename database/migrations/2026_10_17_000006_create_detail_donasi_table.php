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
     * Tabel detail_donasi menyimpan rincian barang dalam satu pengajuan donasi.
     * FK ke: donasi (CASCADE delete), kebutuhan_panti (RESTRICT delete).
     */
    public function up(): void
    {
        Schema::create('detail_donasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('donasi_id')
                ->constrained('donasi')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('kebutuhan_id')
                ->constrained('kebutuhan_panti')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->decimal('jumlah', 12, 2);
            $table->string('satuan', 30);
            $table->string('catatan_item', 255)->nullable();
            $table->timestamps();

            $table->unique(['donasi_id', 'kebutuhan_id'], 'uq_detail_donasi_kebutuhan');

            $table->index('kebutuhan_id', 'idx_detail_kebutuhan');
        });
        DB::statement('ALTER TABLE detail_donasi ADD CONSTRAINT chk_detail_jumlah CHECK (jumlah > 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_donasi');
    }
};
