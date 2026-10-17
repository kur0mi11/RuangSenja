@extends('admin.layouts.app')

@section('title', 'Tambah Lansia')
@section('heading', 'Tambah Data Lansia')

@section('content')

<div class="mx-auto max-w-4xl">

    <div class="mb-6">
        <a href="{{ route('admin.lansia.index') }}"
           class="text-sm font-medium text-[#0F6B6F] hover:underline">
            &larr; Kembali ke Data Lansia
        </a>
        <h1 class="mt-4 text-2xl font-bold text-[#0F6B6F]">Tambah Data Lansia</h1>
        <p class="mt-1 text-sm text-[#7A6E66]">Isi formulir berikut untuk menambahkan penghuni baru.</p>
    </div>

    <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6 md:p-8">
        @include('admin.lansia._form')
    </div>

</div>

@endsection