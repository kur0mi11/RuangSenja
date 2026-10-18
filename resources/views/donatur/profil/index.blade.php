@extends('donatur.layout')

@section('title', 'Profil Saya')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-[#0A4F52]">Profil Saya</h1>
        <p class="mt-2 text-[#7A6E66]">Kelola data diri dan keamanan akun Anda.</p>
    </div>

    <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
            <p class="text-sm text-[#7A6E66]">Total Donasi</p>
            <p class="mt-1 text-3xl font-extrabold text-[#0F6B6F]">{{ $ringkasan['total'] }}</p>
        </div>
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
            <p class="text-sm text-[#7A6E66]">Menunggu</p>
            <p class="mt-1 text-3xl font-extrabold text-[#E8A33B]">{{ $ringkasan['menunggu'] }}</p>
        </div>
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
            <p class="text-sm text-[#7A6E66]">Diterima</p>
            <p class="mt-1 text-3xl font-extrabold text-[#6FA77B]">{{ $ringkasan['diterima'] }}</p>
        </div>
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
            <p class="text-sm text-[#7A6E66]">Ditolak</p>
            <p class="mt-1 text-3xl font-extrabold text-[#D96C6C]">{{ $ringkasan['ditolak'] }}</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Data diri --}}
        <form method="POST" action="{{ route('donatur.profil.update') }}" class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-bold text-[#0A4F52]">Data Diri</h2>
            <p class="mt-1 text-sm text-[#7A6E66]">Bergabung sejak {{ $pengguna->created_at?->format('d/m/Y') ?? '-' }}</p>

            <div class="mt-5 space-y-4">
                <div>
                    <label for="nama" class="mb-1 block text-sm font-semibold">Nama Lengkap</label>
                    <input id="nama" type="text" name="nama" value="{{ old('nama', $pengguna->nama) }}" required maxlength="100"
                           class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]">
                </div>
                <div>
                    <label for="email" class="mb-1 block text-sm font-semibold">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $pengguna->email) }}" required maxlength="150"
                           class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]">
                </div>
                <div>
                    <label for="no_hp" class="mb-1 block text-sm font-semibold">No. HP</label>
                    <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $pengguna->no_hp) }}" maxlength="20" placeholder="08xxxxxxxxxx"
                           class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]">
                </div>
                <div>
                    <label for="alamat" class="mb-1 block text-sm font-semibold">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" maxlength="500"
                              class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]">{{ old('alamat', $pengguna->alamat) }}</textarea>
                </div>
            </div>

            <button type="submit" class="mt-6 rounded-xl bg-[#0F6B6F] px-6 py-3 text-sm font-bold text-white hover:bg-[#0A4F52]">Simpan Perubahan</button>
        </form>

        {{-- Ganti password --}}
        <form method="POST" action="{{ route('donatur.profil.password') }}" class="self-start rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-bold text-[#0A4F52]">Ganti Password</h2>
            <p class="mt-1 text-sm text-[#7A6E66]">Gunakan minimal 8 karakter.</p>

            <div class="mt-5 space-y-4">
                <div>
                    <label for="password_lama" class="mb-1 block text-sm font-semibold">Password Lama</label>
                    <input id="password_lama" type="password" name="password_lama" required autocomplete="current-password"
                           class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]">
                </div>
                <div>
                    <label for="password" class="mb-1 block text-sm font-semibold">Password Baru</label>
                    <input id="password" type="password" name="password" required minlength="8" autocomplete="new-password"
                           class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]">
                </div>
                <div>
                    <label for="password_confirmation" class="mb-1 block text-sm font-semibold">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required minlength="8" autocomplete="new-password"
                           class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]">
                </div>
            </div>

            <button type="submit" class="mt-6 rounded-xl bg-[#F47C4C] px-6 py-3 text-sm font-bold text-white hover:bg-[#F9A06B]">Ganti Password</button>
        </form>
    </div>
@endsection
