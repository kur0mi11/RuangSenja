@extends('admin.layouts.app')

@section('title', 'Pengajuan Donasi')
@section('heading', 'Pengajuan Donasi')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-[#0F6B6F]">
        Pengajuan Donasi
    </h1>
    <p class="mt-1 text-sm text-[#7A6E66]">
        kelola dan periksa pengajuan donasi dari donatur
    </p>
</div>

<div class="mb-6 rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">

    <form action="{{ route('admin.donasi.index') }}"
          method="GET"
          class="flex flex-wrap items-end gap-4">

        <div class="min-w-[200px] flex-1">
            <label for="cari" class="mb-2 block text-sm font-semibold">
                Cari Donasi
            </label>

            <input type="text"
                   id="cari"
                   name="cari"
                   value="{{ $cari }}"
                   placeholder="Kode donasi atau nama donatur..."
                   class="w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F]">
        </div>

        <div class="min-w-[145px]">
            <label for="status" class="mb-2 block text-sm font-semibold">
                Status
            </label>

            <select id="status"
                    name="status"
                    class="w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F]">
                <option value="">Semua Status</option>
                <option value="menunggu" @selected($status === 'menunggu')>Menunggu</option>
                <option value="diterima" @selected($status === 'diterima')>Diterima</option>
                <option value="ditolak" @selected($status === 'ditolak')>Ditolak</option>
            </select>
        </div>

        <div class="min-w-[140px]">
            <label for="tipe" class="mb-2 block text-sm font-semibold">
                Tipe Donasi
            </label>

            <select id="tipe"
                    name="tipe"
                    class="w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F]">
                <option value="">Semua Tipe</option>
                <option value="uang" @selected($tipe === 'uang')>Uang</option>
                <option value="barang" @selected($tipe === 'barang')>Barang</option>
            </select>
        </div>

        <button type="submit"
                class="rounded-xl bg-[#0F6B6F] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0A4F52]">
            Cari
        </button>

        <a href="{{ route('admin.donasi.index') }}"
           class="rounded-xl border border-[#E8D9C8] px-5 py-3 text-sm font-semibold hover:bg-[#F6EBDD]">
            Reset
        </a>
    </form>
</div>

<div class="overflow-hidden rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9]">

    <div class="border-b border-[#E8D9C8] px-6 py-5">
        <h2 class="text-lg font-bold text-[#0F6B6F]">
            Daftar Pengajuan
        </h2>
        <p class="mt-1 text-sm text-[#7A6E66]">
            Total {{ $daftarDonasi->total() }} pengajuan ditemukan
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">

            <thead class="bg-[#F6EBDD] text-[#4A403A]">
                <tr>
                    <th class="px-5 py-4 font-semibold">No.</th>
                    <th class="px-5 py-4 font-semibold">Kode Donasi</th>
                    <th class="px-5 py-4 font-semibold">Donatur</th>
                    <th class="px-5 py-4 font-semibold">Tipe</th>
                    <th class="px-5 py-4 font-semibold">Nominal</th>
                    <th class="px-5 py-4 font-semibold">Tanggal</th>
                    <th class="px-5 py-4 font-semibold">Status</th>
                    <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-[#E8D9C8]">
                @forelse ($daftarDonasi as $item)

                    @php
                        $warnaStatus = match ($item->status) {
                            'menunggu' => 'bg-amber-100 text-amber-800',
                            'diterima' => 'bg-green-100 text-green-800',
                            'ditolak' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp

                    <tr class="transition hover:bg-[#FFF8F1]">
                        <td class="px-5 py-4">
                            {{ $daftarDonasi->firstItem() + $loop->index }}
                        </td>

                        <td class="px-5 py-4 font-semibold text-[#0F6B6F]">
                            {{ $item->kode_donasi }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->donatur?->nama ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            {{ ucfirst($item->tipe_donasi) }}
                        </td>

                        <td class="px-5 py-4">
                            @if ($item->tipe_donasi === 'uang')
                                Rp {{ number_format((float) $item->nominal, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>

                        <td class="px-5 py-4 whitespace-nowrap">
                            {{ $item->created_at?->format('d/m/Y') ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $warnaStatus }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('admin.donasi.show', $item) }}"
                               class="font-medium text-[#0F6B6F] hover:underline">
                                Detail
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-14 text-center">
                            <p class="font-semibold text-[#4A403A]">
                                {{ $cari !== '' || $status !== '' || $tipe !== ''
                                    ? 'tidak ada pengajuan yang sesuai'
                                    : 'belum ada pengajuan donasi' }}
                            </p>

                            <p class="mt-2 text-sm text-[#7A6E66]">
                                {{ $cari !== '' || $status !== '' || $tipe !== ''
                                    ? 'coba ubah pencarian atau filter'
                                    : 'pengajuan dari donatur akan tampil di sini' }}
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($daftarDonasi->hasPages())
        <div class="border-t border-[#E8D9C8] px-6 py-5">
            {{ $daftarDonasi->links() }}
        </div>
    @endif

</div>

@endsection