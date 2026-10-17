@extends('admin.layouts.app')

@section('title', 'Detail Donasi')
@section('heading', 'Pengajuan Donasi')

@section('content')

@php
    $warnaStatus = match ($donasi->status) {
        'menunggu' => 'bg-amber-100 text-amber-800',
        'diterima' => 'bg-green-100 text-green-800',
        'ditolak' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<div class="mb-6">
    <a href="{{ route('admin.donasi.index') }}"
       class="text-sm font-medium text-[#0F6B6F] hover:underline">
        ← Kembali ke Pengajuan Donasi
    </a>

    <div class="mt-5 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#0F6B6F]">
                Detail Pengajuan Donasi
            </h1>
            <p class="mt-1 text-sm text-[#7A6E66]">
                {{ $donasi->kode_donasi }}
            </p>
        </div>

        <span class="rounded-full px-4 py-2 text-sm font-semibold {{ $warnaStatus }}">
            {{ ucfirst($donasi->status) }}
        </span>
    </div>
</div>

<div class="grid gap-6 lg:grid-cols-3">

    <div class="space-y-6 lg:col-span-2">

        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
            <h2 class="mb-5 text-lg font-bold text-[#0F6B6F]">
                Informasi Donasi
            </h2>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-[#7A6E66]">Kode Donasi</p>
                    <p class="mt-1 font-semibold">
                        {{ $donasi->kode_donasi }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-[#7A6E66]">Tanggal Pengajuan</p>
                    <p class="mt-1 font-semibold">
                        {{ $donasi->created_at?->format('d/m/Y H:i') ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-[#7A6E66]">Tipe Donasi</p>
                    <p class="mt-1 font-semibold">
                        {{ ucfirst($donasi->tipe_donasi) }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-[#7A6E66]">Metode Donasi</p>
                    <p class="mt-1 font-semibold">
                        {{ ucfirst($donasi->metode_donasi) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
            <h2 class="mb-5 text-lg font-bold text-[#0F6B6F]">
                Rincian Donasi
            </h2>

            @if ($donasi->tipe_donasi === 'uang')

                <p class="text-sm text-[#7A6E66]">Nominal Donasi</p>
                <p class="mt-2 text-2xl font-bold text-[#0F6B6F]">
                    Rp {{ number_format((float) $donasi->nominal, 2, ',', '.') }}
                </p>

                <div class="mt-5 border-t border-[#E8D9C8] pt-5">
                    <p class="text-sm text-[#7A6E66]">Bukti Transfer</p>

                    @if ($donasi->bukti_transfer)
                        <a href="{{ route('admin.donasi.bukti-transfer', $donasi) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-2 inline-block rounded-xl bg-[#0F6B6F] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0A4F52]">
                            Lihat Bukti Transfer
                        </a>
                    @else
                        <p class="mt-1 text-sm text-[#7A6E66]">
                            Tidak ada bukti transfer
                        </p>
                    @endif

                </div>

            @else

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-[#F6EBDD]">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Kebutuhan</th>
                                <th class="px-4 py-3 font-semibold">Jumlah</th>
                                <th class="px-4 py-3 font-semibold">Catatan</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#E8D9C8]">
                            @forelse ($donasi->detailDonasi as $detail)
                                <tr>
                                    <td class="px-4 py-3">
                                        {{ $namaKebutuhan[$detail->kebutuhan_id] ?? ('Kebutuhan #' . $detail->kebutuhan_id) }}
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ number_format((float) $detail->jumlah, 2, ',', '.') }}
                                        {{ $detail->satuan }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $detail->catatan_item ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center text-[#7A6E66]">
                                        belum ada rincian barang
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @endif

            <div class="mt-5 border-t border-[#E8D9C8] pt-5">
                <p class="text-sm font-semibold">Catatan Donatur</p>
                <p class="mt-2 whitespace-pre-line text-sm text-[#7A6E66]">{{ $donasi->catatan_donatur ?: 'Tidak ada catatan.' }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
            <h2 class="mb-5 text-lg font-bold text-[#0F6B6F]">
                Riwayat Pemrosesan
            </h2>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-[#7A6E66]">Diproses Oleh</p>
                    <p class="mt-1 font-semibold">
                        {{ $donasi->diprosesOleh?->nama ?? 'Belum diproses' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-[#7A6E66]">Tanggal Diproses</p>
                    <p class="mt-1 font-semibold">
                        {{ $donasi->diproses_pada?->format('d/m/Y H:i') ?? '-' }}
                    </p>
                </div>
            </div>

            @if ($donasi->catatan_admin)
                <div class="mt-5 border-t border-[#E8D9C8] pt-5">
                    <p class="text-sm font-semibold">Catatan Admin</p>
                    <p class="mt-2 whitespace-pre-line text-sm text-[#7A6E66]">{{ $donasi->catatan_admin }}</p>
                </div>
            @endif
        </div>

    </div>

    <div class="space-y-6">

        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
            <h2 class="mb-5 text-lg font-bold text-[#0F6B6F]">
                Informasi Donatur
            </h2>

            <div class="space-y-4 text-sm">
                <div>
                    <p class="text-[#7A6E66]">Nama Donatur</p>
                    <p class="mt-1 font-semibold">
                        {{ $donasi->donatur?->nama ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-[#7A6E66]">Email</p>
                    <p class="mt-1 break-all font-medium">
                        {{ $donasi->donatur?->email ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-[#7A6E66]">Nomor Telepon</p>
                    <p class="mt-1 font-medium">
                        {{ $donasi->donatur?->no_hp ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-[#7A6E66]">Alamat</p>
                    <p class="mt-1 whitespace-pre-line font-medium">{{ $donasi->donatur?->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        @if ($donasi->status === 'menunggu')

            <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
                <h2 class="text-lg font-bold text-[#0F6B6F]">
                    Proses Pengajuan
                </h2>

                <p class="mt-2 text-sm text-[#7A6E66]">
                    Periksa informasi donasi sebelum menentukan keputusan.
                </p>

                @if ($errors->any())
                    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.donasi.proses', $donasi) }}"
                      method="POST"
                      class="mt-5"
                      onsubmit="return confirm('Yakin ingin menerima pengajuan ini?')">

                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="status" value="diterima">

                    <button type="submit"
                            class="w-full rounded-xl bg-[#0F6B6F] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0A4F52]">
                        Terima Pengajuan
                    </button>
                </form>

                <div class="my-6 border-t border-[#E8D9C8]"></div>

                <form action="{{ route('admin.donasi.proses', $donasi) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')">

                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="status" value="ditolak">

                    <label for="catatan_admin"
                           class="mb-2 block text-sm font-semibold">
                        Alasan Penolakan
                    </label>

                    <textarea id="catatan_admin"
                              name="catatan_admin"
                              rows="4"
                              maxlength="2000"
                              required
                              placeholder="Tuliskan alasan penolakan..."
                              class="w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F]">{{ old('catatan_admin') }}</textarea>

                    <button type="submit"
                            class="mt-4 w-full rounded-xl border border-red-300 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-50">
                        Tolak Pengajuan
                    </button>
                </form>
            </div>

        @else

            <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
                <h2 class="text-lg font-bold text-[#0F6B6F]">
                    Status Pengajuan
                </h2>

                <p class="mt-3 text-sm text-[#7A6E66]">
                    Pengajuan ini sudah diproses dengan status
                    <span class="font-semibold">
                        {{ ucfirst($donasi->status) }}.
                    </span>
                </p>
            </div>

        @endif

    </div>
</div>

@endsection