@php
    $navAdmin = [
        ['label' => 'Dashboard',       'route' => 'admin.dashboard'],
        ['label' => 'Data Lansia',     'route' => 'admin.lansia.index'],
        ['label' => 'Kebutuhan Panti', 'route' => 'admin.kebutuhan.index'],
        ['label' => 'Pengajuan Donasi','route' => 'admin.donasi.index'],
    ];
@endphp

{{-- ─── Topbar (header) Desktop + Mobile nav ─────────────── --}}
<header class="sticky top-0 z-30 border-b border-[#E8D9C8] bg-[#FFFDF9]/95 backdrop-blur-sm">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-6 py-4 lg:px-8">

        {{-- Judul halaman --}}
        <div>
            <h1 class="text-lg font-bold text-[#0F6B6F] lg:text-xl">
                @yield('heading', 'Panel Admin')
            </h1>
        </div>

        {{-- Kanan: link profil + logout --}}
        <div class="flex items-center gap-3">
            @php
                try { $topbarProfilUrl = route('admin.profil.index'); } catch (\Exception $e) { $topbarProfilUrl = '#'; }
                $topbarProfilActive = request()->routeIs('admin.profil.*');
            @endphp
            <a href="{{ $topbarProfilUrl }}"
               class="hidden items-center gap-2 rounded-full px-4 py-1.5 text-sm font-medium transition sm:inline-flex
                      {{ $topbarProfilActive
                           ? 'bg-[#CFE8E6] text-[#0A4F52]'
                           : 'bg-[#F6EBDD] text-[#4A403A] hover:bg-[#CFE8E6]' }}">
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#0F6B6F] text-[10px] font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}
                </span>
                {{ auth()->user()->nama ?? 'Admin' }}
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="rounded-full border border-[#D9C4B3] px-4 py-1.5 text-sm font-medium text-[#7A6E66] transition hover:bg-[#F6EBDD] hover:text-[#4A403A]">
                    Keluar
                </button>
            </form>
        </div>
    </div>

    {{-- Mobile nav: horizontal scroll --}}
    <nav class="flex gap-1 overflow-x-auto border-t border-[#E8D9C8] px-4 py-2 lg:hidden"
         aria-label="Navigasi mobile admin">
        @foreach ($navAdmin as $item)
            @php
                $isActive = request()->routeIs($item['route'])
                    || (str_ends_with($item['route'], '.index') && request()->routeIs(str_replace('.index', '.*', $item['route'])));
            @endphp
            <a href="{{ route($item['route']) }}"
               class="flex-shrink-0 rounded-lg px-3 py-1.5 text-xs font-semibold transition
                      {{ $isActive
                           ? 'bg-[#0F6B6F] text-white'
                           : 'bg-[#F6EBDD] text-[#4A403A] hover:bg-[#CFE8E6]' }}"
               aria-current="{{ $isActive ? 'page' : 'false' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
        {{-- Profil di mobile nav --}}
        @php
            $profilMobileActive = request()->routeIs('admin.profil.*');
        @endphp
        <a href="{{ $topbarProfilUrl ?? route('admin.profil.index') }}"
           class="flex-shrink-0 rounded-lg px-3 py-1.5 text-xs font-semibold transition
                  {{ $profilMobileActive
                       ? 'bg-[#0F6B6F] text-white'
                       : 'bg-[#F6EBDD] text-[#4A403A] hover:bg-[#CFE8E6]' }}"
           aria-current="{{ $profilMobileActive ? 'page' : 'false' }}">
            Profil
        </a>
    </nav>
</header>
