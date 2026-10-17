@extends('admin.layouts.app')

@section('title', 'Detail Lansia')
@section('heading', 'Detail Lansia')

@section('content')

<div class="mx-auto max-w-5xl">

    <!-- header -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.lansia.index') }}"
               class="text-sm font-medium text-[#0F6B6F] hover:underline">
                &larr; Kembali ke Data Lansia
            </a>

            <h1 class="mt-4 text-2xl font-bold text-[#0F6B6F]">
                Detail Data Lansia
            </h1>

            <p class="mt-1 text-sm text-[#7A6E66]">
                informasi lengkap penghuni panti
            </p>
        </div>

        <a href="{{ route('admin.lansia.edit', $lansia) }}"
           class="rounded-xl bg-[#F47C4C] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#D95F2E]">
            Edit Data
        </a>
    </div>

    <!-- detail Lansia -->
    <div class="overflow-hidden rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9]">

        <div class="grid grid-cols-1 gap-8 p-6 md:grid-cols-[220px_1fr] md:p-8">

            <!-- foto Lansia -->
            <div>
                <div class="flex aspect-square items-center justify-center overflow-hidden rounded-2xl bg-[#F6EBDD]">

                    @if ($lansia->foto)
                        <img
                            src="{{ route('admin.lansia.foto', $lansia) }}"
                            alt="Foto {{ $lansia->nama_lengkap }}"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <span class="text-sm text-[#7A6E66]">
                            Tidak ada foto
                        </span>
                    @endif

                </div>
            </div>

            <!-- main info -->
            <div>
                <h2 class="text-2xl font-bold text-[#4A403A]">
                    {{ $lansia->nama_lengkap }}
                </h2>

                @php
                    $warnaStatus = match ($lansia->status_penghuni) {
                        'aktif' => 'bg-green-100 text-green-800',
                        'pindah' => 'bg-amber-100 text-amber-800',
                        'meninggal' => 'bg-gray-200 text-gray-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                <span class="mt-3 inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $warnaStatus }}">
                    {{ ucfirst($lansia->status_penghuni) }}
                </span>

                <dl class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2">

                    <div>
                        <dt class="text-sm text-[#7A6E66]">
                            Jenis Kelamin
                        </dt>
                        <dd class="mt-1 font-semibold">
                            {{ ucfirst($lansia->jenis_kelamin) }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm text-[#7A6E66]">
                            Usia
                        </dt>
                        <dd class="mt-1 font-semibold">
                            {{ $lansia->tanggal_lahir
                                ? $lansia->tanggal_lahir->age . ' tahun'
                                : '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm text-[#7A6E66]">
                            Tanggal Lahir
                        </dt>
                        <dd class="mt-1 font-semibold">
                            {{ $lansia->tanggal_lahir
                                ? $lansia->tanggal_lahir->format('d/m/Y')
                                : '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm text-[#7A6E66]">
                            Nomor Kamar
                        </dt>
                        <dd class="mt-1 font-semibold">
                            {{ $lansia->nomor_kamar ?? '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm text-[#7A6E66]">
                            Tanggal Masuk
                        </dt>
                        <dd class="mt-1 font-semibold">
                            {{ $lansia->tanggal_masuk
                                ? $lansia->tanggal_masuk->format('d/m/Y')
                                : '-' }}
                        </dd>
                    </div>

                </dl>
            </div>
        </div>

        <!-- keterangan -->
        <div class="border-t border-[#E8D9C8] px-6 py-6 md:px-8">
            <h3 class="text-base font-bold text-[#0F6B6F]">
                Keterangan
            </h3>

            <p class="mt-3 whitespace-pre-line text-sm leading-7 text-[#4A403A]">{{ $lansia->keterangan ?: 'Tidak ada keterangan tambahan.' }}</p>
        </div>

    </div>

</div>

@endsection