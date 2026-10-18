@php
    $navAdmin = [
        [
            'label'  => 'Dashboard',
            'route'  => 'admin.dashboard',
            'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
        ],
        [
            'label'  => 'Data Lansia',
            'route'  => 'admin.lansia.index',
            'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        ],
        [
            'label'  => 'Kebutuhan Panti',
            'route'  => 'admin.kebutuhan.index',
            'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>',
        ],
        [
            'label'  => 'Pengajuan Donasi',
            'route'  => 'admin.donasi.index',
            'icon'   => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>',
        ],
    ];
@endphp

{{-- ─── Sidebar Desktop ─────────────────────────────────── --}}
<aside id="sidebar-admin"
       class="hidden lg:flex lg:w-60 lg:flex-col lg:flex-shrink-0 min-h-screen bg-[#0A4F52] text-white">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 py-7 border-b border-white/10">
        <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-[#F47C4C] text-sm font-bold text-white shadow">
            RS
        </div>
        <div>
            <p class="text-base font-bold leading-tight">RuangSenja</p>
            <p class="text-[11px] text-white/50 font-medium">Panel Administrator</p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex flex-col gap-1 px-3 py-4 flex-1" aria-label="Menu admin">
        <p class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-widest text-white/35">
            Menu Utama
        </p>

        @foreach ($navAdmin as $item)
            @php
                $isActive = request()->routeIs($item['route'])
                    || (str_ends_with($item['route'], '.index') && request()->routeIs(str_replace('.index', '.*', $item['route'])));
            @endphp
            <a href="{{ route($item['route']) }}"
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
        <div class="mb-2 flex items-center gap-3 rounded-xl bg-white/5 px-3 py-3">
            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-[#CFE8E6] text-xs font-bold text-[#0A4F52]">
                {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->nama ?? 'Admin' }}</p>
                <p class="text-[11px] text-white/45">Administrator</p>
            </div>
        </div>

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
