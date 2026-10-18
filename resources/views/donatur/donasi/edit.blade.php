@extends('donatur.layout')

@section('title', 'Edit Donasi')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-[#0A4F52]">Edit Donasi</h1>
        <p class="mt-2 text-[#7A6E66]">Ubah pengajuan {{ $donasi->kode_donasi }} selama statusnya masih menunggu.</p>
    </div>
    @include('donatur.donasi._form')
@endsection
