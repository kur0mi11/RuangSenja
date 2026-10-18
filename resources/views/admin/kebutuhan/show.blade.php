@extends('admin.layouts.app')

@section('title', $kebutuhan->nama_kebutuhan)
@section('heading', 'Detail Kebutuhan Panti')

@section('content')

@php
    $warnaPrioritas = match ($kebutuhan->prioritas) {
        'tinggi' => 'bg-red-100 text-red-700',
        'sedang' => 'bg-amber-100 text-amber-700',
        'rendah' => 'bg-blue-100 text-blue-700',
        default  => 'bg-gray-100 text-gray-600',
    };
    $warnaStatus = $kebutuhan->status_kebutuhan === 'aktif'
        ? 'bg-green-100 text-green-800'
        : 'bg-gray-200 text-gray-600';
@endphp

{{-- breadcrumb / aksi header --}}
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.kebutuhan.index') }}"
           class="rounded-lg border border-[#E8D9C8] px-4 py-2 text-sm font-medium text-[#7A6E66] transition hover:bg-[#F6EBDD]">
            &larr; Kembali
        </a>
        <div>
            <h1 class="text-2xl font-bold text-[#0F6B6F]">{{ $kebutuhan->nama_kebutuhan }}</h1>
            <p class="mt-1 text-sm text-[#7A6E66]">Detail informasi kebutuhan panti</p>
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.kebutuhan.edit', $kebutuhan) }}"
           class="rounded-xl border border-[#D95F2E] px-5 py-2.5 text-sm font-semibold text-[#D95F2E] transition hover:bg-[#FFF0EB]">
            Edit
        </a>

        <form action="{{ route('admin.kebutuhan.destroy', $kebutuhan) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus kebutuhan ini?\n\nKebutuhan yang sudah terkait riwayat donasi tidak dapat dihapus.')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="rounded-xl border border-red-300 px-5 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-50">
                Hapus
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- info utama --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- kartu info --}}
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
            <h2 class="mb-5 text-base font-bold text-[#0F6B6F]">Informasi Kebutuhan</h2>

            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <dt class="mb-1 text-xs font-semibold uppercase tracking-wide text-[#7A6E66]">Nama Kebutuhan</dt>
                    <dd class="font-semibold text-[#4A403A]">{{ $kebutuhan->nama_kebutuhan }}</dd>
                </div>

                <div>
                    <dt class="mb-1 text-xs font-semibold uppercase tracking-wide text-[#7A6E66]">Kategori</dt>
                    <dd class="font-semibold text-[#4A403A]">{{ $kebutuhan->kategori->nama_kategori ?? '-' }}</dd>
                </div>

                <div>
                    <dt class="mb-1 text-xs font-semibold uppercase tracking-wide text-[#7A6E66]">Jumlah Dibutuhkan</dt>
                    <dd class="font-semibold text-[#4A403A]">
                        {{ number_format((float) $kebutuhan->jumlah_dibutuhkan, 0, ',', '.') }}
                        {{ $kebutuhan->satuan }}
                    </dd>
                </div>

                <div>
                    <dt class="mb-1 text-xs font-semibold uppercase tracking-wide text-[#7A6E66]">Sudah Terpenuhi</dt>
                    <dd class="font-semibold text-[#4A403A]">
                        {{ number_format($jumlahTerpenuhi, 0, ',', '.') }}
                        {{ $kebutuhan->satuan }}
                        <span class="ml-1 text-xs text-[#7A6E66]">({{ $persentase }}%)</span>
                    </dd>
                </div>

                <div>
                    <dt class="mb-1 text-xs font-semibold uppercase tracking-wide text-[#7A6E66]">Prioritas</dt>
                    <dd>
                        <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $warnaPrioritas }}">
                            {{ ucfirst($kebutuhan->prioritas) }}
                        </span>
                    </dd>
                </div>

                <div>
                    <dt class="mb-1 text-xs font-semibold uppercase tracking-wide text-[#7A6E66]">Status</dt>
                    <dd>
                        <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $warnaStatus }}">
                            {{ ucfirst($kebutuhan->status_kebutuhan) }}
                        </span>
                    </dd>
                </div>

                @if ($kebutuhan->dibuatOleh)
                    <div>
                        <dt class="mb-1 text-xs font-semibold uppercase tracking-wide text-[#7A6E66]">Dibuat Oleh</dt>
                        <dd class="text-[#4A403A]">{{ $kebutuhan->dibuatOleh->nama }}</dd>
                    </div>
                @endif

                <div>
                    <dt class="mb-1 text-xs font-semibold uppercase tracking-wide text-[#7A6E66]">Ditambahkan</dt>
                    <dd class="text-[#4A403A]">{{ $kebutuhan->created_at->translatedFormat('d F Y') }}</dd>
                </div>

            </dl>

            @if ($kebutuhan->deskripsi)
                <div class="mt-5 border-t border-[#E8D9C8] pt-5">
                    <dt class="mb-2 text-xs font-semibold uppercase tracking-wide text-[#7A6E66]">Deskripsi</dt>
                    <dd class="text-sm leading-relaxed text-[#4A403A]">{{ $kebutuhan->deskripsi }}</dd>
                </div>
            @endif
        </div>

    </div>

    {{-- sidebar progres --}}
    <div class="space-y-6">

        {{-- progress bar --}}
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
            <h2 class="mb-4 text-base font-bold text-[#0F6B6F]">Progres Terpenuhi</h2>

            <div class="mb-2 flex items-end justify-between text-sm">
                <span class="text-[#7A6E66]">Terpenuhi</span>
                <span class="font-bold text-[#0F6B6F]">{{ $persentase }}%</span>
            </div>

            {{-- track --}}
            <div class="h-3 w-full overflow-hidden rounded-full bg-[#CFE8E6]">
                <div
                    class="h-full rounded-full bg-[#0F6B6F] transition-all"
                    style="width: {{ $persentase }}%"
                    role="progressbar"
                    aria-valuenow="{{ $persentase }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                ></div>
            </div>

            <p class="mt-3 text-xs text-[#7A6E66]">
                {{ number_format($jumlahTerpenuhi, 0, ',', '.') }} /
                {{ number_format((float) $kebutuhan->jumlah_dibutuhkan, 0, ',', '.') }}
                {{ $kebutuhan->satuan }}
            </p>

            <p class="mt-2 text-xs text-[#B5A79C]">
                Dihitung dari donasi barang yang sudah <strong>Diterima</strong>.
            </p>
        </div>

        {{-- info singkat --}}
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6 text-sm">
            <h2 class="mb-3 text-base font-bold text-[#0F6B6F]">Informasi Tambahan</h2>
            <p class="text-[#7A6E66]">
                Terakhir diperbarui:<br>
                <span class="font-semibold text-[#4A403A]">
                    {{ $kebutuhan->updated_at->translatedFormat('d F Y, H:i') }} WIB
                </span>
            </p>
        </div>

    </div>
</div>

@endsection
