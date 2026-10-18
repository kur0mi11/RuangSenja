<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriKebutuhanSeeder extends Seeder
{
    /**
     * Seed data awal kategori kebutuhan panti.
     *
     * Kategori ini bersifat statis pada MVP.
     * Sesuai PRD poin 11.10: kategori awal disediakan melalui seeder.
     */
    public function run(): void
    {
        $now = now();

        $kategori = [
            ['nama_kategori' => 'Makanan & Minuman',       'deskripsi' => 'Kebutuhan pangan harian seperti beras, lauk-pauk, dan minuman.'],
            ['nama_kategori' => 'Pakaian & Tekstil',       'deskripsi' => 'Pakaian, handuk, seprai, dan perlengkapan tekstil lainnya.'],
            ['nama_kategori' => 'Kebersihan & Sanitasi',   'deskripsi' => 'Sabun, shampo, odol, pembalut dewasa, dan produk kebersihan.'],
            ['nama_kategori' => 'Kesehatan & Medis',       'deskripsi' => 'Obat-obatan umum, vitamin, alat bantu, dan perlengkapan medis.'],
            ['nama_kategori' => 'Peralatan & Furnitur',    'deskripsi' => 'Peralatan rumah tangga, furnitur, dan perlengkapan kamar.'],
            ['nama_kategori' => 'Hiburan & Kegiatan',      'deskripsi' => 'Buku, alat permainan, perlengkapan aktivitas lansia.'],
            ['nama_kategori' => 'Lain-lain',               'deskripsi' => 'Kebutuhan lain yang tidak termasuk kategori di atas.'],
        ];

        foreach ($kategori as $item) {
            DB::table('kategori_kebutuhan')->updateOrInsert(
                ['nama_kategori' => $item['nama_kategori']],
                ['deskripsi' => $item['deskripsi'], 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
