<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin') | RuangSenja</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-[#FFF8F1] text-[#4A403A]"
      style="font-family: 'Plus Jakarta Sans', sans-serif;">

    @php
        $menu = [
            ['label' => 'Dashboard',       'route' => 'admin.dashboard'],
            ['label' => 'Data Lansia',     'route' => 'admin.lansia.index'],
            ['label' => 'Kebutuhan Panti', 'route' => 'admin.kebutuhan.index'],
            ['label' => 'Pengajuan Donasi','route' => 'admin.donasi.index'],
        ];
    @endphp

    <div class="min-h-screen lg:flex">

        <!-- Sidebar Admin -->
        <aside class="hidden lg:flex lg:w-64 lg:flex-col bg-[#0F6B6F] text-white p-6">

            <div class="mb-10">
                <h1 class="text-2xl font-bold">RuangSenja</h1>
                <p class="mt-1 text-sm text-white/70">Panel Administrator</p>
            </div>

            <nav class="flex flex-col gap-2">
                @foreach ($menu as $item)
                    @if (Route::has($item['route']))
                        <a href="{{ route($item['route']) }}"
                           class="rounded-xl px-4 py-3 text-sm transition hover:bg-white/15
                           {{ request()->routeIs($item['route']) ? 'bg-white/20 font-semibold' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span class="rounded-xl px-4 py-3 text-sm text-white/50">
                            {{ $item['label'] }}
                        </span>
                    @endif
                @endforeach
            </nav>
        </aside>

        <div class="flex-1 min-w-0">

            <header class="border-b border-[#E8D9C8] bg-[#FFFDF9] px-6 py-5">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-[#0F6B6F]">
                            @yield('heading', 'Panel Admin')
                        </h2>
                        <p class="text-sm text-[#7A6E66]">
                            Sistem Donasi Panti Jompo
                        </p>
                    </div>

                    <span class="rounded-full bg-[#F6EBDD] px-4 py-2 text-sm font-medium text-[#4A403A]">
                        {{ auth()->user()->nama }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit"
                                class="rounded-full border border-[#D9C4B3] px-4 py-2 text-sm font-medium text-[#7A6E66] transition hover:bg-[#F6EBDD]">
                            Keluar
                        </button>
                    </form>
                </div>

                <nav class="mt-4 flex flex-wrap gap-2 lg:hidden">
                    @foreach ($menu as $item)
                        @if (Route::has($item['route']))
                            <a href="{{ route($item['route']) }}"
                               class="rounded-lg bg-[#0F6B6F] px-3 py-2 text-xs font-medium text-white">
                                {{ $item['label'] }}
                            </a>
                        @endif
                    @endforeach
                </nav>
            </header>

            <main class="mx-auto max-w-7xl p-6 lg:p-8">

                @if (session('success'))
                    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800"
                         role="status">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800"
                         role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')

            </main>
        </div>
    </div>

</body>
</html>