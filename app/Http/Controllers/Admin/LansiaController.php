<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Throwable;

class LansiaController extends Controller
{
    //buat nampilin daftar lansia
    public function index(Request $request)
    {
        $cari = trim((string) $request->query('cari', ''));
        $status = (string) $request->query('status', '');

        $query = Lansia::query();

        if ($cari !== '') {
            $query->where('nama_lengkap', 'ilike', '%' . $cari . '%');
        }

        if (in_array($status, ['aktif', 'pindah', 'meninggal'], true)) {
            $query->where('status_penghuni', $status);
        }

        $lansia = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.lansia.index', compact('lansia', 'cari', 'status'));
    }

    //buat nampilin form tambah lansia
    public function create()
    {
        return view('admin.lansia.create');
    }

    //buat nyimpen data lansia baru
    public function store(Request $request)
    {
        $data = $this->validasi($request);
        unset($data['foto']);

        $fotoBaru = null;

        try {
            if ($request->hasFile('foto')) {
                $fotoBaru = $request->file('foto')->store('lansia', 'local');

                if (!$fotoBaru) {
                    throw new \RuntimeException('Penyimpanan foto gagal.');
                }

                $data['foto'] = $fotoBaru;
            }

            Lansia::create($data);
        } catch (Throwable $e) {
            if ($fotoBaru) {
                try {
                    Storage::disk('local')->delete($fotoBaru);
                } catch (Throwable $cleanupError) {
                    report($cleanupError);
                }
            }

            report($e);

            return back()->withInput()
                ->with('error', 'Data lansia gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->route('admin.lansia.index')
            ->with('success', 'Data lansia berhasil ditambahkan.');
    }

    //buat nampilin detail lansia
    public function show(Lansia $lansia)
    {
        return view('admin.lansia.show', compact('lansia'));
    }

    //buat nampilin form edit lansia
    public function edit(Lansia $lansia)
    {
        return view('admin.lansia.edit', compact('lansia'));
    }

    //buat update data lansia
    public function update(Request $request, Lansia $lansia)
    {
        $data = $this->validasi($request);
        unset($data['foto']);

        $fotoLama = $lansia->foto;
        $fotoBaru = null;

        try {
            if ($request->hasFile('foto')) {
                $fotoBaru = $request->file('foto')->store('lansia', 'local');

                if (!$fotoBaru) {
                    throw new \RuntimeException('Penyimpanan foto gagal.');
                }

                $data['foto'] = $fotoBaru;
            }

            $lansia->update($data);
        } catch (Throwable $e) {
            if ($fotoBaru) {
                try {
                    Storage::disk('local')->delete($fotoBaru);
                } catch (Throwable $cleanupError) {
                    report($cleanupError);
                }
            }

            report($e);

            return back()->withInput()
                ->with('error', 'Data lansia gagal diperbarui. Silakan coba lagi.');
        }

        if ($fotoBaru && $fotoLama) {
            try {
                Storage::disk('local')->delete($fotoLama);
            } catch (Throwable $e) {
                report($e);
            }
        }

        return redirect()->route('admin.lansia.index')
            ->with('success', 'Data lansia berhasil diperbarui.');
    }

    //buat ngapus data lansia
    public function destroy(Lansia $lansia)
    {
        $foto = $lansia->foto;

        try {
            $lansia->delete();
        } catch (Throwable $e) {
            report($e);

            return back()
                ->with('error', 'Data lansia gagal dihapus. Silakan coba lagi.');
        }

        if ($foto) {
            try {
                Storage::disk('local')->delete($foto);
            } catch (Throwable $e) {
                report($e);
            }
        }

        return redirect()->route('admin.lansia.index')
            ->with('success', 'Data lansia berhasil dihapus.');
    }

    //buat nampilin foto lansia (privat tapi)
    public function foto(Lansia $lansia)
    {
        if (!$lansia->foto || !Storage::disk('local')->exists($lansia->foto)) {
            abort(404);
        }

        return Storage::disk('local')->response($lansia->foto);
    }

    //buat validasi data lansia (tambah sm edit)
    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'tanggal_lahir' => ['nullable', 'date', 'before_or_equal:today'],
            'jenis_kelamin' => ['required', Rule::in(['laki-laki', 'perempuan'])],
            'nomor_kamar' => ['nullable', 'string', 'max:30'],
            'tanggal_masuk' => ['nullable', 'date', 'before_or_equal:today'],
            'keterangan' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status_penghuni' => ['required', Rule::in(['aktif', 'pindah', 'meninggal'])],
        ]);
    }
}