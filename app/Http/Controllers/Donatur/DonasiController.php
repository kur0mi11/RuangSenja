<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\KebutuhanPanti;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class DonasiController extends Controller
{
    public function kebutuhan(): View
    {
        $kebutuhan = KebutuhanPanti::query()
            ->with('kategori')
            ->where('status_kebutuhan', 'aktif')
            ->orderByRaw("CASE prioritas WHEN 'tinggi' THEN 1 WHEN 'sedang' THEN 2 ELSE 3 END")
            ->orderBy('nama_kebutuhan')
            ->paginate(12);

        return view('donatur.kebutuhan.index', compact('kebutuhan'));
    }

    public function index(): View
    {
        $donasi = Donasi::query()
            ->where('donatur_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('donatur.donasi.index', compact('donasi'));
    }

    public function create(): View
    {
        $kebutuhan = $this->kebutuhanUntukForm();

        return view('donatur.donasi.create', compact('kebutuhan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateDonation($request);
        $buktiTransfer = $this->storeTransferProof($request->file('bukti_transfer'));

        try {
            $donasi = DB::transaction(function () use ($validated, $buktiTransfer) {
                $items = $this->validatedItems($validated, null);
                $donasi = Donasi::create([
                    'kode_donasi' => $this->newDonationCode(),
                    'donatur_id' => auth()->id(),
                    'tipe_donasi' => $validated['tipe_donasi'],
                    'nominal' => $validated['tipe_donasi'] === 'uang' ? $validated['nominal'] : null,
                    'metode_donasi' => $validated['metode_donasi'],
                    'bukti_transfer' => $buktiTransfer,
                    'catatan_donatur' => $validated['catatan_donatur'] ?? null,
                    'status' => 'menunggu',
                ]);

                if ($items !== []) {
                    $donasi->detailDonasi()->createMany($items);
                }

                return $donasi;
            });
        } catch (Throwable $exception) {
            if ($buktiTransfer !== null) {
                Storage::disk('local')->delete($buktiTransfer);
            }

            throw $exception;
        }

        return redirect()
            ->route('donatur.donasi.show', $donasi)
            ->with('success', 'Pengajuan donasi berhasil dikirim.');
    }

    public function show(int $donasi): View
    {
        $donasi = $this->ownedDonation($donasi)->with([
            'detailDonasi.kebutuhan.kategori',
        ])->firstOrFail();

        return view('donatur.donasi.show', compact('donasi'));
    }

    public function edit(int $donasi): View|RedirectResponse
    {
        $donasi = $this->ownedDonation($donasi)
            ->with('detailDonasi.kebutuhan')
            ->firstOrFail();

        if ($donasi->status !== 'menunggu') {
            return redirect()
                ->route('donatur.donasi.show', $donasi)
                ->with('error', 'Donasi yang sudah diproses tidak dapat diubah.');
        }

        $kebutuhan = $this->kebutuhanUntukForm($donasi);

        return view('donatur.donasi.edit', compact('donasi', 'kebutuhan'));
    }

    public function update(Request $request, int $donasi): RedirectResponse
    {
        $current = $this->ownedDonation($donasi)
            ->with('detailDonasi')
            ->firstOrFail();

        if ($current->status !== 'menunggu') {
            return redirect()
                ->route('donatur.donasi.show', $current)
                ->with('error', 'Donasi yang sudah diproses tidak dapat diubah.');
        }

        $validated = $this->validateDonation($request);
        $newProof = $this->storeTransferProof($request->file('bukti_transfer'));
        $oldProof = $current->bukti_transfer;
        $proofPath = $newProof ?? (
            $validated['metode_donasi'] === 'transfer' ? $oldProof : null
        );

        try {
            DB::transaction(function () use ($current, $validated, $proofPath) {
                $locked = $this->ownedDonation($current->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($locked->status !== 'menunggu') {
                    throw ValidationException::withMessages([
                        'donasi' => 'Donasi yang sudah diproses tidak dapat diubah.',
                    ]);
                }

                $locked->loadMissing('detailDonasi');
                $items = $this->validatedItems($validated, $locked);

                $locked->update([
                    'tipe_donasi' => $validated['tipe_donasi'],
                    'nominal' => $validated['tipe_donasi'] === 'uang' ? $validated['nominal'] : null,
                    'metode_donasi' => $validated['metode_donasi'],
                    'bukti_transfer' => $proofPath,
                    'catatan_donatur' => $validated['catatan_donatur'] ?? null,
                ]);

                $locked->detailDonasi()->delete();
                if ($items !== []) {
                    $locked->detailDonasi()->createMany($items);
                }
            });
        } catch (Throwable $exception) {
            if ($newProof !== null) {
                Storage::disk('local')->delete($newProof);
            }

            throw $exception;
        }

        if ($oldProof !== null && $proofPath !== $oldProof) {
            $this->deleteTransferProof($oldProof);
        }

        return redirect()
            ->route('donatur.donasi.show', $current)
            ->with('success', 'Pengajuan donasi berhasil diperbarui.');
    }

    public function destroy(int $donasi): RedirectResponse
    {
        $owned = $this->ownedDonation($donasi);
        $proofPath = null;

        $deleted = DB::transaction(function () use ($owned, &$proofPath): bool {
            $donasi = (clone $owned)->lockForUpdate()->firstOrFail();

            if ($donasi->status !== 'menunggu') {
                return false;
            }

            $proofPath = $donasi->bukti_transfer;
            $donasi->delete();

            return true;
        });

        if (!$deleted) {
            return redirect()
                ->route('donatur.donasi.show', $donasi)
                ->with('error', 'Donasi yang sudah diproses tidak dapat dihapus.');
        }

        if ($proofPath !== null) {
            $this->deleteTransferProof($proofPath);
        }

        return redirect()
            ->route('donatur.donasi.index')
            ->with('success', 'Pengajuan donasi berhasil dihapus.');
    }

    private function validateDonation(Request $request): array
    {
        $type = $request->input('tipe_donasi');
        $method = $request->input('metode_donasi');
        $moneyTransfer = $type === 'uang' && $method === 'transfer';

        return $request->validate([
            'tipe_donasi' => ['required', Rule::in(['barang', 'uang'])],
            'metode_donasi' => [
                'required',
                Rule::in($type === 'uang' ? ['langsung', 'transfer'] : ['langsung', 'pengiriman']),
            ],
            'nominal' => $type === 'uang'
                ? ['required', 'numeric', 'decimal:0,2', 'gt:0', 'max:999999999999.99']
                : ['prohibited'],
            'catatan_donatur' => ['nullable', 'string', 'max:2000'],
            'bukti_transfer' => $moneyTransfer
                ? ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120']
                : ['prohibited'],
            'items' => $type === 'barang'
                ? ['required', 'array', 'min:1', 'max:50']
                : ['prohibited'],
            'items.*.kebutuhan_id' => [
                'required',
                'integer',
                'distinct',
                'exists:kebutuhan_panti,id',
            ],
            'items.*.jumlah' => ['required', 'numeric', 'decimal:0,2', 'gt:0', 'max:9999999999.99'],
            'items.*.catatan_item' => ['nullable', 'string', 'max:255'],
        ], [
            'items.required' => 'Pilih minimal satu kebutuhan untuk donasi barang.',
            'items.*.kebutuhan_id.distinct' => 'Setiap kebutuhan hanya boleh dipilih satu kali.',
            'items.*.jumlah.gt' => 'Jumlah setiap barang harus lebih dari 0.',
            'nominal.gt' => 'Nominal donasi harus lebih dari 0.',
            'nominal.decimal' => 'Nominal donasi maksimal memiliki 2 angka di belakang koma.',
            'items.*.jumlah.decimal' => 'Jumlah barang maksimal memiliki 2 angka di belakang koma.',
            'metode_donasi.in' => 'Metode donasi tidak sesuai dengan jenis donasi.',
            'bukti_transfer.mimes' => 'Bukti transfer harus berupa JPG, PNG, atau PDF.',
            'bukti_transfer.max' => 'Ukuran bukti transfer maksimal 5 MB.',
        ]);
    }

    private function validatedItems(array $validated, ?Donasi $donasi): array
    {
        if (($validated['tipe_donasi'] ?? null) !== 'barang') {
            return [];
        }

        $items = $validated['items'] ?? [];
        $ids = collect($items)->pluck('kebutuhan_id')->map(fn ($id) => (int) $id);
        $previousIds = $donasi?->detailDonasi->pluck('kebutuhan_id')->map(fn ($id) => (int) $id) ?? collect();

        $query = KebutuhanPanti::query()
            ->whereIn('id', $ids)
            ->where(function (Builder $query) use ($previousIds) {
                $query->where('status_kebutuhan', 'aktif');
                if ($previousIds->isNotEmpty()) {
                    $query->orWhereIn('id', $previousIds);
                }
            })
            ->lockForUpdate();

        $kebutuhan = $query->get()->keyBy('id');
        if ($kebutuhan->count() !== $ids->unique()->count()) {
            throw ValidationException::withMessages([
                'items' => 'Kebutuhan yang dipilih sudah tidak aktif atau tidak tersedia.',
            ]);
        }

        return collect($items)->map(function (array $item) use ($kebutuhan) {
            $need = $kebutuhan->get((int) $item['kebutuhan_id']);

            return [
                'kebutuhan_id' => $need->id,
                'jumlah' => $item['jumlah'],
                'satuan' => $need->satuan,
                'catatan_item' => $item['catatan_item'] ?? null,
            ];
        })->all();
    }

    private function kebutuhanUntukForm(?Donasi $donasi = null)
    {
        $query = KebutuhanPanti::query()->with('kategori');
        $query->where(function (Builder $query) use ($donasi) {
            $query->where('status_kebutuhan', 'aktif');
            if ($donasi && $donasi->detailDonasi->isNotEmpty()) {
                $query->orWhereIn(
                    'id',
                    $donasi->detailDonasi->pluck('kebutuhan_id')
                );
            }
        });

        return $query->orderBy('nama_kebutuhan')->get();
    }

    private function ownedDonation(int $id): Builder
    {
        return Donasi::query()
            ->whereKey($id)
            ->where('donatur_id', auth()->id());
    }

    private function newDonationCode(): string
    {
        do {
            $code = 'DN-' . Str::upper((string) Str::ulid());
        } while (Donasi::where('kode_donasi', $code)->exists());

        return $code;
    }

    private function storeTransferProof(?UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        $path = $file->store('bukti-transfer', 'local');
        if ($path === false) {
            throw new RuntimeException('Bukti transfer gagal disimpan.');
        }

        return $path;
    }

    private function deleteTransferProof(string $path): void
    {
        if (!str_starts_with($path, 'bukti-transfer/') || str_contains($path, '..')) {
            return;
        }

        if (!Storage::disk('local')->delete($path)) {
            report(new RuntimeException('Bukti transfer gagal dihapus: ' . $path));
        }
    }
}
