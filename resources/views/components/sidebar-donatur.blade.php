@php
    $navDonatur = [
        [
            'label'  => 'Dashboard',
            'route'  => 'donatur.dashboard',
            'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
            'match'  => ['donatur.dashboard'],
        ],
        [
            'label'  => 'Kebutuhan Panti',
            'route'  => 'donatur.kebutuhan.index',
            'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>',
            'match'  => ['donatur.kebutuhan.*'],
        ],
        [
            'label'  => 'Ajukan Donasi',
            'route'  => 'donatur.donasi.create',
            'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>',
            'match'  => ['donatur.donasi.create'],
        ],
        [
            'label'  => 'Riwayat Donasi',
            'route'  => 'donatur.donasi.index',
            'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'match'  => ['donatur.donasi.index', 'donatur.donasi.show'],
        ],
        [
            'label'  => 'FAQ',
            'route'  => 'donatur.faq',
            'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'match'  => ['donatur.faq'],
        ],
    ];
@endphp

{{-- ─── Sidebar Desktop ─────────────────────────────────── --}}
<aside id="sidebar-donatur"
       class="hidden lg:sticky lg:top-0 lg:flex lg:h-screen lg:w-60 lg:flex-col lg:flex-shrink-0 bg-[#0A4F52] text-white">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 py-7 border-b border-white/10">
        <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-[#F47C4C] text-sm font-bold text-white shadow">
            RS
        </div>
        <div>
            <p class="text-base font-bold leading-tight">RuangSenja</p>
            <p class="text-[11px] text-white/50 font-medium">Portal Donatur</p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex flex-1 flex-col gap-1 overflow-y-auto px-3 py-4" aria-label="Menu donatur">
        <p class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-widest text-white/35">
            Menu Utama
        </p>

        @foreach ($navDonatur as $item)
            @php
                // {{-- Gunakan kunci 'match' eksplisit agar tidak ada tumpang-tindih active state --}}
                try {
                    $isActive = request()->routeIs($item['match']);
                } catch (\Exception $e) {
                    $isActive = false;
                }

                try {
                    $routeUrl = route($item['route']);
                } catch (\Exception $e) {
                    $routeUrl = '#';
                }
            @endphp
            <a href="{{ $routeUrl }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-150
                      {{ $isActive
                           ? 'bg-[#0F6B6F] text-white shadow-sm'
                           : 'text-white/70 hover:bg-white/10 hover:text-white' }}"
               aria-current="{{ $isActive ? 'page' : 'false' }}">
                <span class="{{ $isActive ? 'text-white' : 'text-white/50' }}">{!! $item['icon'] !!}</span>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    {{-- User + logout --}}
    <div class="border-t border-white/10 px-3 py-4">
        {{-- Profil: klik untuk ke halaman profil --}}
        @php
            try { $profilUrl = route('donatur.profil.index'); } catch (\Exception $e) { $profilUrl = '#'; }
            $profilActive = request()->routeIs('donatur.profil.*');
        @endphp
        <a href="{{ $profilUrl }}" title="Lihat profil"
           class="mb-2 flex items-center gap-3 rounded-xl px-3 py-3 transition
                  {{ $profilActive ? 'bg-[#0F6B6F]' : 'bg-white/5 hover:bg-white/10' }}">
            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-[#F47C4C]/30 text-xs font-bold text-[#F47C4C]">
                {{ strtoupper(substr(auth()->user()->nama ?? 'D', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->nama ?? 'Donatur' }}</p>
                <p class="text-[11px] text-white/45">Donatur</p>
            </div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-white/60 transition hover:bg-[#D96C6C]/20 hover:text-[#D96C6C]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</aside>
