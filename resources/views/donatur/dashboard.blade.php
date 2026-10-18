@extends('donatur.layouts.app')

@section('title', 'Dashboard Donatur')
@section('heading', 'Dashboard Donatur')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-[#0F6B6F]">Dashboard Donatur</h1>
    <p class="mt-1 text-sm text-[#7A6E66]">
        Selamat datang, <strong>{{ auth()->user()->nama }}</strong> 👋
    </p>
</div>

<div class="rounded-2xl border border-dashed border-[#D9C4B3] bg-[#F6EBDD] px-10 py-16 text-center">
    <div class="text-5xl">🏗️</div>
    <h2 class="mt-4 text-xl font-semibold text-[#0A4F52]">Fitur Sedang Dikembangkan</h2>
    <p class="mt-2 text-sm text-[#7A6E66]">
        Halaman dashboard donatur lengkap akan segera tersedia. Registrasi dan login berhasil!
    </p>
</div>

@endsection
