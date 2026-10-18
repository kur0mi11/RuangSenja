@extends('donatur.layout')

@section('title', 'Kebutuhan Panti')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0A4F52]">Kebutuhan Panti</h1>
            <p class="mt-2 text-[#7A6E66]">Daftar kebutuhan panti yang saat ini berstatus aktif.</p>
        </div>
        <a href="{{ route('donatur.donasi.create') }}" class="rounded-xl bg-[#0F6B6F] px-5 py-3 text-sm font-bold text-white hover:bg-[#0A4F52]">Ajukan donasi</a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($kebutuhan as $item)
            @php
                $prioritasStyle = match ($item->prioritas) {
                    'tinggi' => 'bg-red-100 text-red-800',
                    'sedang' => 'bg-amber-100 text-amber-800',
                    default => 'bg-green-100 text-green-800',
                };
            @endphp
            <article class="flex flex-col rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
                <div class="flex items-start justify-between gap-3">
                    <h2 class="text-lg font-bold text-[#0F6B6F]">{{ $item->nama_kebutuhan }}</h2>
                    <span class="shrink-0 rounded-full px-3 py-1 text-xs font-semibold {{ $prioritasStyle }}">Prioritas {{ ucfirst($item->prioritas) }}</span>
                </div>
                <p class="mt-2 text-sm text-[#7A6E66]">{{ $item->kategori?->nama_kategori ?? '-' }}</p>
                <p class="mt-4 flex-1 whitespace-pre-line text-sm leading-6">{{ $item->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                <div class="mt-5 border-t border-[#E8D9C8] pt-4">
                    <p class="text-xs text-[#7A6E66]">Jumlah dibutuhkan</p>
                    <p class="mt-1 text-lg font-bold">{{ number_format((float) $item->jumlah_dibutuhkan, 2, ',', '.') }} {{ $item->satuan }}</p>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-[#D9C4B3] bg-[#FFFDF9] p-10 text-center text-[#7A6E66]">
                Belum ada kebutuhan panti yang aktif.
            </div>
        @endforelse
    </div>

    @if ($kebutuhan->hasPages())
        <div class="mt-6">{{ $kebutuhan->links() }}</div>
    @endif
@endsection
