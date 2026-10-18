@extends('donatur.layout')

@section('title', 'Dashboard Donatur')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-[#0A4F52]">Dashboard Donatur</h1>
        <p class="mt-2 text-[#7A6E66]">Selamat datang, <strong>{{ auth()->user()->nama }}</strong>. Terima kasih telah berbagi kepedulian.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
            <p class="text-sm text-[#7A6E66]">Kebutuhan aktif</p>
            <p class="mt-2 text-3xl font-bold text-[#0F6B6F]">{{ $jumlahKebutuhanAktif }}</p>
            <a href="{{ route('donatur.kebutuhan.index') }}" class="mt-3 inline-block text-sm font-semibold text-[#0F6B6F] hover:underline">Lihat kebutuhan →</a>
        </div>
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
            <p class="text-sm text-[#7A6E66]">Donasi menunggu</p>
            <p class="mt-2 text-3xl font-bold text-[#0F6B6F]">{{ $jumlahMenunggu }}</p>
            <a href="{{ route('donatur.donasi.index') }}" class="mt-3 inline-block text-sm font-semibold text-[#0F6B6F] hover:underline">Lihat riwayat →</a>
        </div>
        <div class="flex flex-col justify-center rounded-2xl bg-[#0F6B6F] p-5 text-white">
            <p class="text-sm text-white/80">Ingin membantu panti?</p>
            <a href="{{ route('donatur.donasi.create') }}" class="mt-3 inline-flex w-fit rounded-xl bg-white px-4 py-3 text-sm font-bold text-[#0F6B6F] hover:bg-[#F6EBDD]">Ajukan donasi</a>
        </div>
    </div>

    <section class="mt-8 overflow-hidden rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9]">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[#E8D9C8] px-5 py-4">
            <div>
                <h2 class="font-bold text-[#0F6B6F]">Donasi terbaru</h2>
                <p class="mt-1 text-sm text-[#7A6E66]">Status dan detail pengajuan donasi Anda.</p>
            </div>
            <a href="{{ route('donatur.donasi.index') }}" class="text-sm font-semibold text-[#0F6B6F] hover:underline">Semua riwayat</a>
        </div>
        <div class="divide-y divide-[#E8D9C8]">
            @forelse ($donasiTerbaru as $item)
                <a href="{{ route('donatur.donasi.show', $item) }}" class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 hover:bg-[#FFF8F1]">
                    <div>
                        <p class="font-semibold">{{ $item->kode_donasi }}</p>
                        <p class="mt-1 text-sm text-[#7A6E66]">{{ ucfirst($item->tipe_donasi) }} · {{ $item->created_at->format('d/m/Y') }}</p>
                    </div>
                    <span class="rounded-full bg-[#F6EBDD] px-3 py-1 text-xs font-semibold">{{ ucfirst($item->status) }}</span>
                </a>
            @empty
                <p class="px-5 py-8 text-center text-sm text-[#7A6E66]">Anda belum memiliki pengajuan donasi.</p>
            @endforelse
        </div>
    </section>
@endsection
