@extends('admin.layouts.app')

@section('title', 'Data Lansia')
@section('heading', 'Data Lansia')

@section('content')

<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-[#0F6B6F]">
            Data Lansia
        </h1>
        <p class="mt-1 text-sm text-[#7A6E66]">
            kelola informasi penghuni panti jompo
        </p>
    </div>

    <a href="{{ route('admin.lansia.create') }}"
       class="rounded-xl bg-[#F47C4C] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#D95F2E]">
        + tambah lansia
    </a>
</div>

<div class="mb-6 rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">

    <form action="{{ route('admin.lansia.index') }}"
          method="GET"
          class="flex flex-wrap items-end gap-4">

        <div class="min-w-[200px] flex-1">
            <label for="cari"
                   class="mb-2 block text-sm font-semibold">
                Cari Lansia
            </label>

            <input type="text"
                   id="cari"
                   name="cari"
                   value="{{ $cari }}"
                   placeholder="Masukkan nama lansia..."
                   class="w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F]">
        </div>

        <div class="min-w-[170px]">
            <label for="status"
                   class="mb-2 block text-sm font-semibold">
                Status Penghuni
            </label>

            <select id="status"
                    name="status"
                    class="w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F]">

                <option value="">Semua Status</option>
                <option value="aktif" @selected($status === 'aktif')>
                    Aktif
                </option>
                <option value="pindah" @selected($status === 'pindah')>
                    Pindah
                </option>
                <option value="meninggal" @selected($status === 'meninggal')>
                    Meninggal
                </option>
            </select>
        </div>

        <button type="submit"
                class="rounded-xl bg-[#0F6B6F] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0A4F52]">
            Cari
        </button>

        <a href="{{ route('admin.lansia.index') }}"
           class="rounded-xl border border-[#E8D9C8] px-5 py-3 text-sm font-semibold hover:bg-[#F6EBDD]">
            Reset
        </a>
    </form>
</div>

<div class="overflow-hidden rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9]">

    <div class="border-b border-[#E8D9C8] px-6 py-5">
        <h2 class="text-lg font-bold text-[#0F6B6F]">
            Daftar Penghuni
        </h2>
        <p class="mt-1 text-sm text-[#7A6E66]">
            Total {{ $lansia->total() }} data ditemukan
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">

            <thead class="bg-[#F6EBDD] text-[#4A403A]">
                <tr>
                    <th class="px-5 py-4 font-semibold">No.</th>
                    <th class="px-5 py-4 font-semibold">Nama Lengkap</th>
                    <th class="px-5 py-4 font-semibold">Jenis Kelamin</th>
                    <th class="px-5 py-4 font-semibold">Usia</th>
                    <th class="px-5 py-4 font-semibold">Kamar</th>
                    <th class="px-5 py-4 font-semibold">Status</th>
                    <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-[#E8D9C8]">

                @forelse ($lansia as $item)

                    @php
                        $warnaStatus = match ($item->status_penghuni) {
                            'aktif' => 'bg-green-100 text-green-800',
                            'pindah' => 'bg-amber-100 text-amber-800',
                            'meninggal' => 'bg-gray-200 text-gray-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp

                    <tr class="transition hover:bg-[#FFF8F1]">

                        <td class="px-5 py-4">
                            {{ $lansia->firstItem() + $loop->index }}
                        </td>

                        <td class="px-5 py-4 font-semibold">
                            {{ $item->nama_lengkap }}
                        </td>

                        <td class="px-5 py-4">
                            {{ ucfirst($item->jenis_kelamin) }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->tanggal_lahir
                                ? $item->tanggal_lahir->age . ' tahun'
                                : '-' }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->nomor_kamar ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $warnaStatus }}">
                                {{ ucfirst($item->status_penghuni) }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-3">

                                <a href="{{ route('admin.lansia.show', $item) }}"
                                   class="font-medium text-[#0F6B6F] hover:underline">
                                    Detail
                                </a>

                                <a href="{{ route('admin.lansia.edit', $item) }}"
                                   class="font-medium text-[#D95F2E] hover:underline">
                                    Edit
                                </a>

                                <form action="{{ route('admin.lansia.destroy', $item) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data lansia ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="cursor-pointer font-medium text-red-700 hover:underline">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="px-5 py-14 text-center">
                            <p class="font-semibold text-[#4A403A]">
                                belum ada data lansia
                            </p>
                            <p class="mt-2 text-sm text-[#7A6E66]">
                                tambahkan data baru atau ubah pencarian
                            </p>
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    @if ($lansia->hasPages())
        <div class="border-t border-[#E8D9C8] px-6 py-5">
            {{ $lansia->links() }}
        </div>
    @endif

</div>

@endsection