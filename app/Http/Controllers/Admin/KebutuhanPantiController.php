<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKebutuhan;
use App\Models\KebutuhanPanti;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;

class KebutuhanPantiController extends Controller
{
    // Tampilkan daftar kebutuhan panti
    public function index(Request $request)
    {
        $cari      = trim((string) $request->query('cari', ''));
        $status    = (string) $request->query('status', '');
        $kategori  = (string) $request->query('kategori', '');
        $prioritas = (string) $request->query('prioritas', '');

        $query = KebutuhanPanti::with('kategori')->latest();

        if ($cari !== '') {
            $query->where('nama_kebutuhan', 'ilike', '%' . $cari . '%');
        }

        if (in_array($status, ['aktif', 'nonaktif'], true)) {
            $query->where('status_kebutuhan', $status);
        }

        if ($kategori !== '') {
            $query->where('kategori_id', $kategori);
        }

        if (in_array($prioritas, ['rendah', 'sedang', 'tinggi'], true)) {
            $query->where('prioritas', $prioritas);
        }

        $kebutuhan  = $query->paginate(10)->withQueryString();
        $kategoris  = KategoriKebutuhan::orderBy('nama_kategori')->get();

        return view('admin.kebutuhan.index', compact('kebutuhan', 'kategoris', 'cari', 'status', 'kategori', 'prioritas'));
    }

    // Tampilkan form tambah kebutuhan
    public function create()
    {
        $kategoris = KategoriKebutuhan::orderBy('nama_kategori')->get();
        return view('admin.kebutuhan.create', compact('kategoris'));
    }

    // Simpan kebutuhan baru
    public function store(Request $request)
    {
        $data = $this->validasi($request);
        $data['dibuat_oleh'] = auth()->id();

        try {
            KebutuhanPanti::create($data);
        } catch (Throwable $e) {
            report($e);
            return back()->withInput()
                ->with('error', 'Kebutuhan panti gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->route('admin.kebutuhan.index')
            ->with('success', 'Kebutuhan panti berhasil ditambahkan.');
    }

    // Tampilkan detail kebutuhan
    public function show(KebutuhanPanti $kebutuhan)
    {
        $kebutuhan->load('kategori', 'dibuatOleh');
        $jumlahTerpenuhi = $kebutuhan->jumlahTerpenuhi();
        $persentase = $kebutuhan->jumlah_dibutuhkan > 0
            ? min(100, round(($jumlahTerpenuhi / $kebutuhan->jumlah_dibutuhkan) * 100, 1))
            : 0;

        return view('admin.kebutuhan.show', compact('kebutuhan', 'jumlahTerpenuhi', 'persentase'));
    }

    // Tampilkan form edit kebutuhan
    public function edit(KebutuhanPanti $kebutuhan)
    {
        $kategoris = KategoriKebutuhan::orderBy('nama_kategori')->get();
        return view('admin.kebutuhan.edit', compact('kebutuhan', 'kategoris'));
    }

    // Update data kebutuhan
    public function update(Request $request, KebutuhanPanti $kebutuhan)
    {
        $data = $this->validasi($request);

        // Cek aturan: tidak boleh dinonaktifkan jika ada pengajuan Menunggu
        if (
            isset($data['status_kebutuhan']) &&
            $data['status_kebutuhan'] === 'nonaktif' &&
            $kebutuhan->punyaPengajuanMenunggu()
        ) {
            return back()->withInput()
                ->with('error', 'Kebutuhan tidak dapat dinonaktifkan karena masih ada pengajuan donasi yang sedang menunggu.');
        }

        try {
            $kebutuhan->update($data);
        } catch (Throwable $e) {
            report($e);
            return back()->withInput()
                ->with('error', 'Kebutuhan panti gagal diperbarui. Silakan coba lagi.');
        }

        return redirect()->route('admin.kebutuhan.index')
            ->with('success', 'Kebutuhan panti berhasil diperbarui.');
    }

    // Hapus kebutuhan
    public function destroy(KebutuhanPanti $kebutuhan)
    {
        // Cek aturan: tidak boleh dihapus jika ada pengajuan Menunggu
        if ($kebutuhan->punyaPengajuanMenunggu()) {
            return back()
                ->with('error', 'Kebutuhan tidak dapat dihapus karena masih ada pengajuan donasi yang sedang menunggu.');
        }

        // Cek aturan: kebutuhan yang pernah ada dalam riwayat donasi sebaiknya dinonaktifkan
        if ($kebutuhan->detailDonasi()->exists()) {
            return back()
                ->with('error', 'Kebutuhan tidak dapat dihapus karena sudah terkait dengan riwayat donasi. Nonaktifkan kebutuhan sebagai gantinya.');
        }

        try {
            $kebutuhan->delete();
        } catch (Throwable $e) {
            report($e);
            return back()
                ->with('error', 'Kebutuhan panti gagal dihapus. Silakan coba lagi.');
        }

        return redirect()->route('admin.kebutuhan.index')
            ->with('success', 'Kebutuhan panti berhasil dihapus.');
    }

    // Validasi input form
    private function validasi(Request $request): array
    {
        return $request->validate([
            'kategori_id'       => ['required', 'integer', 'exists:kategori_kebutuhan,id'],
            'nama_kebutuhan'    => ['required', 'string', 'max:150'],
            'deskripsi'         => ['nullable', 'string'],
            'jumlah_dibutuhkan' => ['required', 'numeric', 'min:0.01'],
            'satuan'            => ['required', 'string', 'max:30'],
            'prioritas'         => ['required', Rule::in(['rendah', 'sedang', 'tinggi'])],
            'status_kebutuhan'  => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);
    }
}
