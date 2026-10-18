@extends('donatur.layout')

@section('title', 'Ajukan Donasi')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-[#0A4F52]">Ajukan Donasi</h1>
        <p class="mt-2 text-[#7A6E66]">Pilih jenis donasi dan lengkapi informasi pengajuan.</p>
    </div>
    @include('donatur.donasi._form')
@endsection
