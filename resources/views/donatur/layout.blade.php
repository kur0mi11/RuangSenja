<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Donatur') | RuangSenja</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#FFF8F1] text-[#4A403A]" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <header class="border-b border-[#E8D9C8] bg-[#FFFDF9]">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-5 py-4">
            <a href="{{ route('donatur.dashboard') }}" class="text-xl font-extrabold text-[#0F6B6F]">RuangSenja</a>
            <nav class="flex flex-wrap items-center gap-2 text-sm">
                <a href="{{ route('donatur.dashboard') }}"
                   class="rounded-lg px-3 py-2 hover:bg-[#F6EBDD] {{ request()->routeIs('donatur.dashboard') ? 'bg-[#F6EBDD] font-semibold text-[#0F6B6F]' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('donatur.kebutuhan.index') }}"
                   class="rounded-lg px-3 py-2 hover:bg-[#F6EBDD] {{ request()->routeIs('donatur.kebutuhan.*') ? 'bg-[#F6EBDD] font-semibold text-[#0F6B6F]' : '' }}">
                    Kebutuhan Panti
                </a>
                <a href="{{ route('donatur.donasi.create') }}"
                   class="rounded-lg px-3 py-2 hover:bg-[#F6EBDD] {{ request()->routeIs('donatur.donasi.create', 'donatur.donasi.edit') ? 'bg-[#F6EBDD] font-semibold text-[#0F6B6F]' : '' }}">
                    Ajukan Donasi
                </a>
                <a href="{{ route('donatur.donasi.index') }}"
                   class="rounded-lg px-3 py-2 hover:bg-[#F6EBDD] {{ request()->routeIs('donatur.donasi.index', 'donatur.donasi.show') ? 'bg-[#F6EBDD] font-semibold text-[#0F6B6F]' : '' }}">
                    Riwayat Donasi
                </a>
            </nav>
            <div class="flex items-center gap-3 text-sm">
                <span class="hidden text-[#7A6E66] sm:inline">{{ auth()->user()->nama }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg border border-[#D9C4B3] px-3 py-2 font-semibold hover:bg-[#F6EBDD]">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-5 py-8 lg:py-10">
        @if (session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800" role="status">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                <p class="font-bold">Periksa kembali data yang dikirim:</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
