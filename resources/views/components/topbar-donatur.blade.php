@php
    $navDonatur = [
        ['label' => 'Dashboard',       'route' => 'donatur.dashboard'],
        ['label' => 'Kebutuhan Panti', 'route' => 'donatur.kebutuhan.index'],
        ['label' => 'Ajukan Donasi',   'route' => 'donatur.donasi.create'],
        ['label' => 'Riwayat Donasi',  'route' => 'donatur.donasi.index'],
        ['label' => 'FAQ',             'route' => 'donatur.faq'],
        ['label' => 'Profil',          'route' => 'donatur.profil.index'],
    ];
@endphp

{{-- ─── Topbar (header) Desktop + Mobile nav ─────────────── --}}
<header class="sticky top-0 z-30 border-b border-[#E8D9C8] bg-[#FFFDF9]/95 backdrop-blur-sm">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-6 py-4 lg:px-8">

        {{-- Judul halaman --}}
        <div>
            <h1 class="text-lg font-bold text-[#0F6B6F] lg:text-xl">
                @hasSection('heading') @yield('heading') @else @yield('title', 'Portal Donatur') @endif
            </h1>
            <p class="hidden text-xs text-[#7A6E66] sm:block">
                Sistem Informasi Donasi Panti Jompo
            </p>
        </div>

        {{-- Kanan: avatar nama + logout --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('donatur.profil.index') }}" title="Lihat profil" class="hidden rounded-full bg-[#FFF0E5] px-4 py-1.5 text-sm font-medium text-[#4A403A] hover:bg-[#F9C5A8] sm:inline-flex items-center gap-2">
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#F47C4C] text-[10px] font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'D', 0, 1)) }}
                </span>
                {{ auth()->user()->nama ?? 'Donatur' }}
            </a>

            <button type="button" onclick="bukaModalLogout()"
                    class="rounded-full border border-[#D9C4B3] px-4 py-1.5 text-sm font-medium text-[#7A6E66] transition hover:bg-[#F6EBDD] hover:text-[#4A403A]">
                Keluar
            </button>
        </div>
    </div>

    {{-- Mobile nav: horizontal scroll --}}
    <nav class="flex gap-1 overflow-x-auto border-t border-[#E8D9C8] px-4 py-2 lg:hidden"
         aria-label="Navigasi mobile donatur">
        @foreach ($navDonatur as $item)
            @php
                try {
                    $isActive = request()->routeIs($item['route'])
                        || (str_ends_with($item['route'], '.index') && request()->routeIs(str_replace('.index', '.*', $item['route'])))
                        || (str_ends_with($item['route'], '.create') && request()->routeIs(str_replace('.create', '.*', $item['route'])));
                } catch (\Exception $e) {
                    $isActive = false;
                }
            @endphp
            @php
                try {
                    $routeUrl = route($item['route']);
                } catch (\Exception $e) {
                    $routeUrl = '#';
                }
            @endphp
            <a href="{{ $routeUrl }}"
               class="flex-shrink-0 rounded-lg px-3 py-1.5 text-xs font-semibold transition
                      {{ $isActive
                           ? 'bg-[#F47C4C] text-white'
                           : 'bg-[#FFF0E5] text-[#4A403A] hover:bg-[#F9C5A8]' }}"
               aria-current="{{ $isActive ? 'page' : 'false' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</header>
