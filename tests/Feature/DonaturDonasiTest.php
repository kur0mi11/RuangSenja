<?php

namespace Tests\Feature;

use App\Models\Donasi;
use App\Models\KebutuhanPanti;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DonaturDonasiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        Schema::create('pengguna', function ($table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password_hash');
            $table->string('role')->default('donatur');
            $table->string('status_akun')->default('aktif');
            $table->timestamps();
        });
        Schema::create('kategori_kebutuhan', function ($table) {
            $table->id();
            $table->string('nama_kategori');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
        Schema::create('kebutuhan_panti', function ($table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->string('nama_kebutuhan');
            $table->text('deskripsi')->nullable();
            $table->decimal('jumlah_dibutuhkan', 12, 2);
            $table->string('satuan');
            $table->string('prioritas')->default('sedang');
            $table->string('status_kebutuhan')->default('aktif');
            $table->timestamps();
        });
        Schema::create('donasi', function ($table) {
            $table->id();
            $table->string('kode_donasi')->unique();
            $table->unsignedBigInteger('donatur_id');
            $table->string('tipe_donasi');
            $table->decimal('nominal', 14, 2)->nullable();
            $table->string('metode_donasi');
            $table->string('bukti_transfer')->nullable();
            $table->text('catatan_donatur')->nullable();
            $table->string('status')->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->unsignedBigInteger('diproses_oleh')->nullable();
            $table->dateTime('diproses_pada')->nullable();
            $table->timestamps();
        });
        Schema::create('detail_donasi', function ($table) {
            $table->id();
            $table->unsignedBigInteger('donasi_id');
            $table->unsignedBigInteger('kebutuhan_id');
            $table->decimal('jumlah', 12, 2);
            $table->string('satuan');
            $table->string('catatan_item')->nullable();
            $table->timestamps();
            $table->unique(['donasi_id', 'kebutuhan_id']);
        });
    }

    public function test_donatur_can_only_view_active_needs(): void
    {
        $donatur = $this->createDonatur();
        $kategoriId = DB::table('kategori_kebutuhan')->insertGetId([
            'nama_kategori' => 'Pangan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $active = $this->createNeed($kategoriId, 'Beras', 'aktif');
        $this->createNeed($kategoriId, 'Selimut', 'nonaktif');

        $this->actingAs($donatur)
            ->get(route('donatur.kebutuhan.index'))
            ->assertOk()
            ->assertSee('Beras')
            ->assertDontSee('Selimut')
            ->assertSee('Pangan');
    }

    public function test_barang_donation_uses_authenticated_owner_and_need_unit(): void
    {
        $donatur = $this->createDonatur();
        $otherDonatur = $this->createDonatur('oranglain@example.test');
        $kategoriId = DB::table('kategori_kebutuhan')->insertGetId([
            'nama_kategori' => 'Pangan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $need = $this->createNeed($kategoriId, 'Beras', 'aktif');

        $response = $this->actingAs($donatur)->post(route('donatur.donasi.store'), [
            'donatur_id' => $otherDonatur->id,
            'tipe_donasi' => 'barang',
            'metode_donasi' => 'pengiriman',
            'items' => [[
                'kebutuhan_id' => $need->id,
                'jumlah' => 2,
                'satuan' => 'satuan-palsu',
            ]],
        ]);

        $donasi = Donasi::query()->firstOrFail();
        $response->assertRedirect(route('donatur.donasi.show', $donasi));
        $this->assertSame($donatur->id, $donasi->donatur_id);
        $this->assertSame('menunggu', $donasi->status);
        $this->assertSame('barang', $donasi->tipe_donasi);
        $this->assertNull($donasi->nominal);
        $this->assertSame('DN-', substr($donasi->kode_donasi, 0, 3));
        $this->assertDatabaseHas('detail_donasi', [
            'donasi_id' => $donasi->id,
            'kebutuhan_id' => $need->id,
            'jumlah' => 2,
            'satuan' => 'kg',
        ]);
    }

    public function test_money_donation_requires_positive_amount_and_accepts_transfer_method(): void
    {
        $donatur = $this->createDonatur();
        $this->actingAs($donatur)
            ->from(route('donatur.donasi.create'))
            ->post(route('donatur.donasi.store'), [
                'tipe_donasi' => 'uang',
                'metode_donasi' => 'transfer',
                'nominal' => 0,
            ])
            ->assertSessionHasErrors('nominal');

        $this->post(route('donatur.donasi.store'), [
            'tipe_donasi' => 'uang',
            'metode_donasi' => 'transfer',
            'nominal' => '0.001',
        ])->assertSessionHasErrors('nominal');

        $response = $this->post(route('donatur.donasi.store'), [
            'tipe_donasi' => 'uang',
            'metode_donasi' => 'transfer',
            'nominal' => 150000,
            'items' => [],
        ]);

        $donasi = Donasi::query()->firstOrFail();
        $response->assertRedirect(route('donatur.donasi.show', $donasi));
        $this->assertSame('uang', $donasi->tipe_donasi);
        $this->assertSame('150000.00', $donasi->nominal);
        $this->assertSame('transfer', $donasi->metode_donasi);
        $this->assertSame(0, $donasi->detailDonasi()->count());
    }

    public function test_donatur_cannot_access_another_users_donation(): void
    {
        $owner = $this->createDonatur();
        $anotherDonatur = $this->createDonatur('oranglain@example.test');
        $donasi = $this->createDonation($owner, 'menunggu');

        $this->actingAs($anotherDonatur)
            ->get(route('donatur.donasi.show', $donasi))
            ->assertNotFound();
        $this->get(route('donatur.donasi.edit', $donasi))->assertNotFound();
        $this->put(route('donatur.donasi.update', $donasi), [])->assertNotFound();
        $this->delete(route('donatur.donasi.destroy', $donasi))->assertNotFound();

        $this->assertDatabaseHas('donasi', ['id' => $donasi->id]);
    }

    public function test_processed_donation_cannot_be_edited_or_deleted(): void
    {
        $donatur = $this->createDonatur();
        $donasi = $this->createDonation($donatur, 'diterima');

        $this->actingAs($donatur)
            ->put(route('donatur.donasi.update', $donasi), [
                'tipe_donasi' => 'uang',
                'metode_donasi' => 'langsung',
                'nominal' => 999,
            ])
            ->assertRedirect(route('donatur.donasi.show', $donasi))
            ->assertSessionHas('error');

        $this->delete(route('donatur.donasi.destroy', $donasi))
            ->assertRedirect(route('donatur.donasi.show', $donasi))
            ->assertSessionHas('error');
        $this->assertDatabaseHas('donasi', [
            'id' => $donasi->id,
            'status' => 'diterima',
        ]);
    }

    public function test_donatur_routes_reject_guests_and_other_roles(): void
    {
        $this->get(route('donatur.donasi.index'))
            ->assertRedirect(route('login'));

        $admin = $this->createDonatur('admin@example.test');
        $admin->update(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('donatur.donasi.index'))
            ->assertForbidden();
    }

    private function createDonatur(string $email = 'donatur@example.test'): Pengguna
    {
        return Pengguna::create([
            'nama' => 'Donatur Test',
            'email' => $email,
            'password_hash' => 'hashed-password',
            'role' => 'donatur',
            'status_akun' => 'aktif',
        ]);
    }

    private function createNeed(int $kategoriId, string $name, string $status): KebutuhanPanti
    {
        return KebutuhanPanti::create([
            'kategori_id' => $kategoriId,
            'nama_kebutuhan' => $name,
            'jumlah_dibutuhkan' => 20,
            'satuan' => 'kg',
            'prioritas' => 'tinggi',
            'status_kebutuhan' => $status,
        ]);
    }

    private function createDonation(Pengguna $donatur, string $status): Donasi
    {
        return Donasi::create([
            'kode_donasi' => 'DN-TEST-' . $donatur->id . $status,
            'donatur_id' => $donatur->id,
            'tipe_donasi' => 'uang',
            'nominal' => 100,
            'metode_donasi' => 'langsung',
            'status' => $status,
        ]);
    }
}
