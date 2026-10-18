@extends('donatur.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8 rounded-3xl bg-gradient-to-r from-[#0F6B6F] to-[#4F9A9D] p-8 text-white">
        <p class="text-sm font-semibold text-[#CFE8E6]">Selamat datang kembali</p>
        <h1 class="mt-1 text-3xl font-extrabold">{{ auth()->user()->nama }}</h1>
        <p class="mt-2 max-w-xl text-sm text-[#CFE8E6]">
            Terima kasih sudah peduli. Setiap bantuan Anda membuat hari-hari para lansia di panti lebih hangat.
        </p>
        <a href="{{ route('donatur.donasi.create') }}"
           class="mt-5 inline-block rounded-xl bg-[#F47C4C] px-5 py-3 text-sm font-bold text-white hover:bg-[#F9A06B]">
            Ajukan Donasi Baru
        </a>
    </div>

    <div class="mb-8 grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
            <p class="text-sm text-[#7A6E66]">Total Pengajuan Terbaru</p>
            <p class="mt-1 text-3xl font-extrabold text-[#0F6B6F]">{{ $donasiTerbaru->count() }}</p>
            <p class="mt-1 text-xs text-[#B5A79C]">dari 5 pengajuan terakhir</p>
        </div>
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
            <p class="text-sm text-[#7A6E66]">Menunggu Konfirmasi</p>
            <p class="mt-1 text-3xl font-extrabold text-[#E8A33B]">{{ $jumlahMenunggu }}</p>
            <p class="mt-1 text-xs text-[#B5A79C]">masih bisa diubah atau dihapus</p>
        </div>
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
            <p class="text-sm text-[#7A6E66]">Kebutuhan Panti Aktif</p>
            <p class="mt-1 text-3xl font-extrabold text-[#F47C4C]">{{ $jumlahKebutuhanAktif }}</p>
            <a href="{{ route('donatur.kebutuhan.index') }}" class="mt-1 inline-block text-xs font-semibold text-[#0F6B6F] hover:underline">Lihat daftar kebutuhan</a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9]">
        <div class="flex items-center justify-between border-b border-[#E8D9C8] px-5 py-4">
            <h2 class="text-lg font-bold text-[#0A4F52]">Donasi Terbaru</h2>
            <a href="{{ route('donatur.donasi.index') }}" class="text-sm font-semibold text-[#0F6B6F] hover:underline">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[560px] text-left text-sm">
                <thead class="bg-[#F6EBDD]">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Kode</th>
                        <th class="px-5 py-3 font-semibold">Tanggal</th>
                        <th class="px-5 py-3 font-semibold">Jenis</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8D9C8]">
                    @forelse ($donasiTerbaru as $item)
                        @php
                            $warnaStatus = match ($item->status) {
                                'menunggu' => 'bg-amber-100 text-amber-800',
                                'diterima' => 'bg-green-100 text-green-800',
                                'ditolak' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp
                        <tr class="hover:bg-[#FFF8F1]">
                            <td class="px-5 py-3 font-semibold text-[#0F6B6F]">{{ $item->kode_donasi }}</td>
                            <td class="whitespace-nowrap px-5 py-3">{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="px-5 py-3">{{ ucfirst($item->tipe_donasi) }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $warnaStatus }}">{{ ucfirst($item->status) }}</span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('donatur.donasi.show', $item) }}" class="font-semibold text-[#0F6B6F] hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-[#7A6E66]">
                                Belum ada pengajuan donasi.
                                <a href="{{ route('donatur.donasi.create') }}" class="font-semibold text-[#0F6B6F] hover:underline">Mulai berdonasi</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
