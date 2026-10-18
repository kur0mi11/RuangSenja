@extends('donatur.layout')

@section('title', 'Riwayat Donasi')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0A4F52]">Riwayat Donasi</h1>
            <p class="mt-2 text-[#7A6E66]">Daftar pengajuan donasi yang Anda buat.</p>
        </div>
        <a href="{{ route('donatur.donasi.create') }}" class="rounded-xl bg-[#0F6B6F] px-5 py-3 text-sm font-bold text-white hover:bg-[#0A4F52]">Ajukan donasi</a>
    </div>

    <div class="mb-4 flex flex-wrap gap-2 text-sm">
        @foreach ([null => 'Semua', 'menunggu' => 'Menunggu', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'] as $nilai => $label)
            <a href="{{ route('donatur.donasi.index', $nilai ? ['status' => $nilai] : []) }}"
               class="rounded-full border px-4 py-2 font-semibold {{ $status === $nilai ? 'border-[#0F6B6F] bg-[#0F6B6F] text-white' : 'border-[#D9C4B3] bg-[#FFFDF9] hover:bg-[#F6EBDD]' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="overflow-hidden rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[680px] text-left text-sm">
                <thead class="bg-[#F6EBDD]">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Kode Donasi</th>
                        <th class="px-5 py-4 font-semibold">Tanggal</th>
                        <th class="px-5 py-4 font-semibold">Jenis Donasi</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8D9C8]">
                    @forelse ($donasi as $item)
                        <tr class="hover:bg-[#FFF8F1]">
                            <td class="px-5 py-4 font-semibold text-[#0F6B6F]">{{ $item->kode_donasi }}</td>
                            <td class="whitespace-nowrap px-5 py-4">{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="px-5 py-4">{{ ucfirst($item->tipe_donasi) }}</td>
                            <td class="px-5 py-4">
                                @php
                                    $warnaStatus = match ($item->status) {
                                        'menunggu' => 'bg-amber-100 text-amber-800',
                                        'diterima' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $warnaStatus }}">{{ ucfirst($item->status) }}</span>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                <a href="{{ route('donatur.donasi.show', $item) }}" class="font-semibold text-[#0F6B6F] hover:underline">Detail</a>
                                @if ($item->status === 'menunggu')
                                    <span class="px-1 text-[#D9C4B3]">|</span>
                                    <a href="{{ route('donatur.donasi.edit', $item) }}" class="font-semibold text-[#0F6B6F] hover:underline">Edit</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-[#7A6E66]">{{ $status ? 'Tidak ada donasi dengan status ini.' : 'Belum ada pengajuan donasi.' }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($donasi->hasPages())
            <div class="border-t border-[#E8D9C8] px-5 py-4">{{ $donasi->links() }}</div>
        @endif
    </div>
@endsection
