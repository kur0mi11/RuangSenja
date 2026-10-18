<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Donatur') — RuangSenja</title>
    <meta name="description" content="Portal Donatur RuangSenja — Sistem Informasi Donasi Panti Jompo">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: {
                            dark:  '#0A4F52',
                            DEFAULT: '#0F6B6F',
                            light: '#4F9A9D',
                            pale:  '#CFE8E6',
                        },
                        secondary: {
                            DEFAULT: '#F47C4C',
                            light:   '#F9A06B',
                            pale:    '#FFD2B2',
                        },
                        neutral: {
                            bg:     '#FFF8F1',
                            soft:   '#F6EBDD',
                            card:   '#E8D9C8',
                            border: '#D9C4B3',
                        },
                        ink: {
                            primary:   '#4A403A',
                            secondary: '#7A6E66',
                            muted:     '#B5A79C',
                        },
                        status: {
                            success: '#6FA77B',
                            warning: '#E8A33B',
                            danger:  '#D96C6C',
                            info:    '#5E9CA0',
                        },
                    },
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-[#FFF8F1] text-[#4A403A]"
      style="font-family: 'Plus Jakarta Sans', sans-serif;">

    <div class="flex min-h-screen">

        {{-- ── Sidebar ─────────────────────────────────────────── --}}
        @include('components.sidebar-donatur')

        {{-- ── Area konten utama ──────────────────────────────── --}}
        <div class="flex flex-1 flex-col min-w-0">

            {{-- Header / Topbar --}}
            @include('components.topbar-donatur')

            {{-- Flash messages --}}
            <div class="mx-auto w-full max-w-7xl px-6 pt-4">
                @if (session('success'))
                    <div class="mb-4 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"
                         role="status">
                        <span class="mt-0.5 text-green-600">✓</span>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"
                         role="alert">
                        <span class="mt-0.5 text-red-500">✕</span>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            {{-- Error validasi form --}}
            @if ($errors->any())
                <div class="mx-auto w-full max-w-7xl px-6 pb-2">
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                        <p class="font-bold">Periksa kembali data yang dikirim:</p>
                        <ul class="mt-2 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Konten halaman --}}
            <main class="mx-auto w-full max-w-7xl flex-1 px-6 pb-10 pt-2 lg:px-8">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- Pop-up konfirmasi keluar --}}
    <div id="modal-logout" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4"
         onclick="if (event.target === this) tutupModalLogout()">
        <div class="w-full max-w-sm rounded-2xl bg-[#FFFDF9] p-6 text-center shadow-xl" role="dialog" aria-modal="true" aria-labelledby="judul-logout">
            <h2 id="judul-logout" class="text-xl font-extrabold text-[#0A4F52]">Keluar dari RuangSenja?</h2>
            <p class="mt-2 text-sm text-[#7A6E66]">Anda perlu masuk lagi untuk mengakses akun Anda.</p>
            <div class="mt-6 flex justify-center gap-3">
                <button type="button" onclick="tutupModalLogout()"
                        class="rounded-xl border border-[#D9C4B3] px-5 py-3 text-sm font-semibold hover:bg-[#F6EBDD]">Batal</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-xl bg-[#D96C6C] px-5 py-3 text-sm font-bold text-white hover:opacity-90">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function bukaModalLogout() {
            const m = document.getElementById('modal-logout');
            m.classList.remove('hidden');
            m.classList.add('flex');
        }
        function tutupModalLogout() {
            const m = document.getElementById('modal-logout');
            m.classList.add('hidden');
            m.classList.remove('flex');
        }
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') tutupModalLogout(); });
    </script>

</body>
</html>
