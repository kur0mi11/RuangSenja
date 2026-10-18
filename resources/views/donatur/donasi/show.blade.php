@extends('donatur.layout')

@section('title', 'Detail Donasi')

@section('content')
    @php
        $warnaStatus = match ($donasi->status) {
            'menunggu' => 'bg-amber-100 text-amber-800',
            'diterima' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    @endphp

    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('donatur.donasi.index') }}" class="text-sm font-semibold text-[#0F6B6F] hover:underline">← Kembali ke riwayat donasi</a>
            <h1 class="mt-4 text-3xl font-extrabold text-[#0A4F52]">Detail Donasi</h1>
            <p class="mt-2 font-semibold text-[#7A6E66]">{{ $donasi->kode_donasi }}</p>
        </div>
        <span class="rounded-full px-4 py-2 text-sm font-bold {{ $warnaStatus }}">{{ ucfirst($donasi->status) }}</span>
    </div>

    <div class="grid gap-5 lg:grid-cols-3">
        <section class="space-y-5 lg:col-span-2">
            <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 sm:p-6">
                <h2 class="mb-5 text-lg font-bold text-[#0F6B6F]">Informasi Pengajuan</h2>
                <dl class="grid gap-5 sm:grid-cols-2">
                    <div><dt class="text-sm text-[#7A6E66]">Tanggal</dt><dd class="mt-1 font-semibold">{{ $donasi->created_at?->format('d/m/Y H:i') ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-[#7A6E66]">Jenis Donasi</dt><dd class="mt-1 font-semibold">{{ ucfirst($donasi->tipe_donasi) }}</dd></div>
                    <div><dt class="text-sm text-[#7A6E66]">Metode Donasi</dt><dd class="mt-1 font-semibold">{{ ucfirst($donasi->metode_donasi) }}</dd></div>
                    <div><dt class="text-sm text-[#7A6E66]">Status</dt><dd class="mt-1 font-semibold">{{ ucfirst($donasi->status) }}</dd></div>
                </dl>
            </div>

            <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 sm:p-6">
                <h2 class="mb-5 text-lg font-bold text-[#0F6B6F]">Rincian Donasi</h2>
                @if ($donasi->tipe_donasi === 'uang')
                    <p class="text-sm text-[#7A6E66]">Nominal</p>
                    <p class="text-2xl font-extrabold text-[#0F6B6F]">Rp {{ number_format((float) $donasi->nominal, 2, ',', '.') }}</p>
                    @if ($donasi->metode_donasi === 'transfer')
                        <p class="mt-3 text-sm text-[#7A6E66]">{{ $donasi->bukti_transfer ? 'Bukti transfer telah diunggah.' : 'Belum ada bukti transfer.' }}</p>
                    @endif
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[520px] text-left text-sm">
                            <thead class="bg-[#F6EBDD]"><tr><th class="px-4 py-3 font-semibold">Kebutuhan</th><th class="px-4 py-3 font-semibold">Kategori</th><th class="px-4 py-3 font-semibold">Jumlah</th><th class="px-4 py-3 font-semibold">Catatan</th></tr></thead>
                            <tbody class="divide-y divide-[#E8D9C8]">
                                @forelse ($donasi->detailDonasi as $detail)
                                    <tr>
                                        <td class="px-4 py-3">{{ $detail->kebutuhan?->nama_kebutuhan ?? 'Kebutuhan #' . $detail->kebutuhan_id }}</td>
                                        <td class="px-4 py-3">{{ $detail->kebutuhan?->kategori?->nama_kategori ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3">{{ number_format((float) $detail->jumlah, 2, ',', '.') }} {{ $detail->satuan }}</td>
                                        <td class="px-4 py-3">{{ $detail->catatan_item ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-4 py-6 text-center text-[#7A6E66]">Belum ada rincian barang.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="mt-5 border-t border-[#E8D9C8] pt-5">
                    <p class="text-sm font-semibold">Catatan Donatur</p>
                    <p class="mt-2 whitespace-pre-line text-sm text-[#7A6E66]">{{ $donasi->catatan_donatur ?: 'Tidak ada catatan.' }}</p>
                </div>
            </div>

            @if ($donasi->catatan_admin)
                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 sm:p-6">
                    <h2 class="font-bold text-amber-900">Catatan Admin</h2>
                    <p class="mt-2 whitespace-pre-line text-sm text-amber-900">{{ $donasi->catatan_admin }}</p>
                </div>
            @endif
        </section>

        <aside class="h-fit rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 sm:p-6">
            <h2 class="mb-4 text-lg font-bold text-[#0F6B6F]">Aksi</h2>
            @if ($donasi->status === 'menunggu')
                <a href="{{ route('donatur.donasi.edit', $donasi) }}" class="block rounded-xl bg-[#0F6B6F] px-4 py-3 text-center text-sm font-bold text-white hover:bg-[#0A4F52]">Edit Pengajuan</a>
                <form method="POST" action="{{ route('donatur.donasi.destroy', $donasi) }}" class="mt-3" onsubmit="return confirm('Hapus pengajuan donasi ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full rounded-xl border border-red-300 px-4 py-3 text-sm font-bold text-red-700 hover:bg-red-50">Hapus Pengajuan</button>
                </form>
            @else
                <p class="text-sm leading-6 text-[#7A6E66]">Pengajuan yang telah diproses tidak dapat diedit atau dihapus.</p>
            @endif
        </aside>
    </div>
@endsection
