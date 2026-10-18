@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('heading', 'Dashboard Admin')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-[#0F6B6F]">Dashboard Admin</h1>
    <p class="mt-1 text-sm text-[#7A6E66]">
        Selamat datang, <strong>{{ auth()->user()->nama }}</strong> 👋
    </p>
</div>

<div class="rounded-2xl border border-dashed border-[#D9C4B3] bg-[#F6EBDD] px-10 py-16 text-center">
    <div class="text-5xl">🏗️</div>
    <h2 class="mt-4 text-xl font-semibold text-[#0A4F52]">Fitur Sedang Dikembangkan</h2>
    <p class="mt-2 text-sm text-[#7A6E66]">
        Halaman dashboard admin lengkap akan segera tersedia. Autentikasi berhasil!
    </p>
</div>

@endsection
