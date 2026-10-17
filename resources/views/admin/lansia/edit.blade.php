@extends('admin.layouts.app')

@section('title', 'Edit Lansia')
@section('heading', 'Edit Data Lansia')

@section('content')

<div class="mx-auto max-w-4xl">

    <div class="mb-6">
        <a href="{{ route('admin.lansia.show', $lansia) }}"
           class="text-sm font-medium text-[#0F6B6F] hover:underline">
            &larr; Kembali ke Detail
        </a>
        <h1 class="mt-4 text-2xl font-bold text-[#0F6B6F]">Edit Data Lansia</h1>
        <p class="mt-1 text-sm text-[#7A6E66]">Perbarui informasi penghuni panti.</p>
    </div>

    <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6 md:p-8">
        @include('admin.lansia._form')
    </div>

</div>

@endsection