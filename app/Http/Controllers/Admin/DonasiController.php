<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DonasiController extends Controller
{
    /**
     * menampilkan daftar seluruh pengajuan donasi
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'cari'   => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['menunggu', 'diterima', 'ditolak'])],
            'tipe'   => ['nullable', Rule::in(['barang', 'uang'])],
        ]);

        $cari = trim($validated['cari'] ?? '');
        $status = $validated['status'] ?? '';
        $tipe = $validated['tipe'] ?? '';

        $query = Donasi::with('donatur');

        //pencarian kode donasi atau nama donatur
        if ($cari !== '') {
            $query->where(function ($q) use ($cari) {
                $q->where('kode_donasi', 'ilike', "%{$cari}%")
                    ->orWhereHas('donatur', function ($q) use ($cari) {
                        $q->where('nama', 'ilike', "%{$cari}%");
                    });
            });
        }

        //filter status pengajuan
        if ($status !== '') {
            $query->where('status', $status);
        }

        //filter tipe donasi
        if ($tipe !== '') {
            $query->where('tipe_donasi', $tipe);
        }

        $daftarDonasi = $query
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.donasi.index', compact(
            'daftarDonasi',
            'cari',
            'status',
            'tipe'
        ));
    }

    /**
     * menampilkan detail pengajuan donasi
     */

    public function show(Donasi $donasi): View
    {
        $donasi->load([
            'donatur',
            'diprosesOleh',
            'detailDonasi',
        ]);

        //ambil nama kebutuhan dari rincian donasi barang
        $namaKebutuhan = DB::table('kebutuhan_panti')
            ->whereIn('id', $donasi->detailDonasi->pluck('kebutuhan_id'))
            ->pluck('nama_kebutuhan', 'id');

        return view('admin.donasi.show', compact(
            'donasi',
            'namaKebutuhan'
        ));
    }

    /**
     * menerima atau menolak pengajuan donasi.
     */
    public function proses(
        Request $request,
        Donasi $donasi
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['diterima', 'ditolak']),
            ],
            'catatan_admin' => [
                'nullable',
                'string',
                'max:2000',
                'required_if:status,ditolak',
            ],
        ], [
            'catatan_admin.required_if' =>
                'Alasan penolakan wajib diisi.',
        ]);

        //cuma pengajuan Menunggu yang bisa diproses
        $jumlahDiubah = Donasi::query()
            ->whereKey($donasi->id)
            ->where('status', 'menunggu')
            ->update([
                'status' => $validated['status'],
                'catatan_admin' =>
                    $validated['catatan_admin'] ?? null,
                'diproses_oleh' => auth()->id(),
                'diproses_pada' => now(),
            ]);

        if ($jumlahDiubah !== 1) {
            return redirect()
                ->route('admin.donasi.show', $donasi)
                ->with(
                    'error',
                    'Pengajuan ini sudah diproses dan tidak dapat diubah kembali.'
                );
        }

        return redirect()
            ->route('admin.donasi.show', $donasi)
            ->with(
                'success',
                'Pengajuan donasi berhasil ' .
                $validated['status'] . '.'
            );
    }


    //nampilin bukti transfer secara private
    public function buktiTransfer(Donasi $donasi): StreamedResponse
    {
        $path = $donasi->bukti_transfer;

        if (
            $donasi->tipe_donasi !== 'uang' ||
            $donasi->metode_donasi !== 'transfer' ||
            !$path ||
            !str_starts_with($path, 'bukti-transfer/') ||
            str_contains($path, '..') ||
            !Storage::disk('local')->exists($path)
        ) {
            abort(404, 'Bukti transfer tidak ditemukan.');
        }

        return Storage::disk('local')->response($path);
    }

}