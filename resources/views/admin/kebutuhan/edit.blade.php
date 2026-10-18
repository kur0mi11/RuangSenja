@extends('admin.layouts.app')

@section('title', 'Edit Kebutuhan — ' . $kebutuhan->nama_kebutuhan)
@section('heading', 'Edit Kebutuhan Panti')

@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.kebutuhan.index') }}"
       class="rounded-lg border border-[#E8D9C8] px-4 py-2 text-sm font-medium text-[#7A6E66] transition hover:bg-[#F6EBDD]">
        &larr; Kembali
    </a>
    <div>
        <h1 class="text-2xl font-bold text-[#0F6B6F]">Edit Kebutuhan Panti</h1>
        <p class="mt-1 text-sm text-[#7A6E66]">{{ $kebutuhan->nama_kebutuhan }}</p>
    </div>
</div>

<div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6 lg:p-8">
    @include('admin.kebutuhan._form')
</div>

@endsection
