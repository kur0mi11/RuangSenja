@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('heading', 'Dashboard Admin')

@section('content')

{{-- header --}}
<div class="mb-7 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-[#0F6B6F]">
            Ringkasan Panti
        </h1>
    </div>

    <a href="{{ route('admin.donasi.index', ['status' => 'menunggu']) }}"
       class="inline-flex items-center rounded-xl bg-[#F47C4C] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#D95F2E]">
        Periksa Pengajuan
    </a>
</div>

{{-- statistik --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

    {{-- pengajuan menunggu --}}
    <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
        <p class="text-sm font-medium text-[#7A6E66]">
            Pengajuan Menunggu
        </p>

        <p class="mt-4 text-3xl font-bold text-[#0F6B6F]">
            {{ number_format($pengajuanMenunggu, 0, ',', '.') }}
        </p>

        <div class="mt-4 border-t border-[#E8D9C8] pt-3">
            <a href="{{ route('admin.donasi.index', ['status' => 'menunggu']) }}"
               class="text-sm font-semibold text-[#0F6B6F] hover:underline">
                Periksa Pengajuan
            </a>
        </div>
    </div>

    {{-- penghuni aktif --}}
    <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
        <p class="text-sm font-medium text-[#7A6E66]">
            Penghuni Aktif
        </p>

        <p class="mt-4 text-3xl font-bold text-[#0F6B6F]">
            {{ number_format($penghuniAktif, 0, ',', '.') }}
        </p>

        <div class="mt-4 border-t border-[#E8D9C8] pt-3">
            <a href="{{ route('admin.lansia.index', ['status' => 'aktif']) }}"
               class="text-sm font-semibold text-[#0F6B6F] hover:underline">
                Lihat Data Lansia
            </a>
        </div>
    </div>

    {{-- kebutuhan aktif --}}
    <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
        <p class="text-sm font-medium text-[#7A6E66]">
            Kebutuhan Aktif
        </p>

        <p class="mt-4 text-3xl font-bold text-[#0F6B6F]">
            {{ number_format($kebutuhanAktif, 0, ',', '.') }}
        </p>

        <div class="mt-4 border-t border-[#E8D9C8] pt-3">
            <a href="{{ route('admin.kebutuhan.index', ['status' => 'aktif']) }}"
               class="text-sm font-semibold text-[#0F6B6F] hover:underline">
                Lihat Kebutuhan
            </a>
        </div>
    </div>

    {{-- donasi diterima --}}
    <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
        <p class="text-sm font-medium text-[#7A6E66]">
            Donasi Diterima
        </p>

        <p class="mt-4 text-3xl font-bold text-[#0F6B6F]">
            {{ number_format($donasiDiterima, 0, ',', '.') }}
        </p>

        <div class="mt-4 border-t border-[#E8D9C8] pt-3">
            <a href="{{ route('admin.donasi.index', ['status' => 'diterima']) }}"
               class="text-sm font-semibold text-[#0F6B6F] hover:underline">
                Lihat Riwayat Donasi
            </a>
        </div>
    </div>

</div>

{{-- tabel pengajuan terbaru --}}
<div class="mt-7 overflow-hidden rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9]">

    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-[#E8D9C8] px-6 py-5">
        <div>
            <h2 class="text-lg font-bold text-[#0F6B6F]">
                Pengajuan Donasi Terbaru
            </h2>
        </div>

        <a href="{{ route('admin.donasi.index') }}"
           class="text-sm font-semibold text-[#0F6B6F] hover:underline">
            Lihat Semua
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">

            <thead class="bg-[#F6EBDD] text-[#4A403A]">
                <tr>
                    <th class="px-5 py-4 font-semibold">Kode Donasi</th>
                    <th class="px-5 py-4 font-semibold">Donatur</th>
                    <th class="px-5 py-4 font-semibold">Tipe</th>
                    <th class="px-5 py-4 font-semibold">Tanggal</th>
                    <th class="px-5 py-4 font-semibold">Status</th>
                    <th class="px-5 py-4 text-center font-semibold">Aksi</th>
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

                    <tr class="transition hover:bg-[#FFF8F1]">
                        <td class="px-5 py-4 font-semibold text-[#0F6B6F]">
                            {{ $item->kode_donasi }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->donatur?->nama ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            {{ ucfirst($item->tipe_donasi) }}
                        </td>

                        <td class="whitespace-nowrap px-5 py-4">
                            {{ $item->created_at?->format('d/m/Y') ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $warnaStatus }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('admin.donasi.show', $item) }}"
                               class="font-semibold text-[#0F6B6F] hover:underline">
                                Detail
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <p class="font-semibold text-[#4A403A]">
                                Belum ada pengajuan donasi
                            </p>
                            <p class="mt-2 text-sm text-[#7A6E66]">
                                Pengajuan baru akan ditampilkan di sini.
                            </p>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>

{{-- akses cepat --}}
<div class="mt-7">
    <div class="mb-4">
        <h2 class="text-lg font-bold text-[#0F6B6F]">
            Akses Cepat
        </h2>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

        {{-- Tombol tambah lansia --}}
        <a href="{{ route('admin.lansia.create') }}"
           class="group flex items-center gap-4 rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] px-5 py-5 transition hover:border-[#0F6B6F] hover:bg-[#FDF6EE] hover:shadow-sm">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#F6EBDD] text-[#0F6B6F]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 19v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 8v6m3-3h-6" />
                </svg>
            </div>

            <div class="min-w-0">
                <p class="text-base font-bold text-[#0F6B6F]">
                    Tambah Data Lansia
                </p>
                <p class="mt-1 text-sm text-[#7A6E66]">
                    Form input penghuni
                </p>
            </div>
        </a>

        {{-- Tombol tambah kebutuhan --}}
        <a href="{{ route('admin.kebutuhan.create') }}"
           class="group flex items-center gap-4 rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] px-5 py-5 transition hover:border-[#0F6B6F] hover:bg-[#FDF6EE] hover:shadow-sm">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#F6EBDD] text-[#0F6B6F]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 7h16M7 3h10a1 1 0 0 1 1 1v16l-3-2-3 2-3-2-3 2V4a1 1 0 0 1 1-1Z" />
                </svg>
            </div>

            <div class="min-w-0">
                <p class="text-base font-bold text-[#0F6B6F]">
                    Tambah Kebutuhan Panti
                </p>
                <p class="mt-1 text-sm text-[#7A6E66]">
                    Form kebutuhan baru
                </p>
            </div>
        </a>

        {{-- Tombol pengajuan donasi --}}
        <a href="{{ route('admin.donasi.index') }}"
           class="group flex items-center gap-4 rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] px-5 py-5 transition hover:border-[#0F6B6F] hover:bg-[#FDF6EE] hover:shadow-sm">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#F6EBDD] text-[#0F6B6F]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8c-2.2 0-4 1.12-4 2.5S9.8 13 12 13s4 1.12 4 2.5S14.2 18 12 18s-4-1.12-4-2.5" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6v12" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 12a8 8 0 1 0 16 0a8 8 0 1 0-16 0" />
                </svg>
            </div>

            <div class="min-w-0">
                <p class="text-base font-bold text-[#0F6B6F]">
                    Kelola Pengajuan Donasi
                </p>
                <p class="mt-1 text-sm text-[#7A6E66]">
                    Lihat dan proses pengajuan
                </p>
            </div>
        </a>

    </div>
</div>

@endsection