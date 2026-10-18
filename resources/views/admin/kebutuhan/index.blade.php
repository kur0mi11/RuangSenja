@extends('admin.layouts.app')

@section('title', 'Kebutuhan Panti')
@section('heading', 'Kebutuhan Panti')

@section('content')

{{-- header + tombol tambah --}}
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-[#0F6B6F]">Kebutuhan Panti</h1>
        <p class="mt-1 text-sm text-[#7A6E66]">Kelola daftar kebutuhan yang ditampilkan kepada donatur</p>
    </div>

    <a href="{{ route('admin.kebutuhan.create') }}"
       class="rounded-xl bg-[#F47C4C] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#D95F2E]">
        + Tambah Kebutuhan
    </a>
</div>

{{-- filter --}}
<div class="mb-6 rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
    <form action="{{ route('admin.kebutuhan.index') }}" method="GET"
          class="flex flex-wrap items-end gap-4">

        <div class="min-w-[200px] flex-1">
            <label for="cari" class="mb-2 block text-sm font-semibold">Cari Kebutuhan</label>
            <input type="text" id="cari" name="cari" value="{{ $cari }}"
                   placeholder="Masukkan nama kebutuhan..."
                   class="w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F]">
        </div>

        <div class="min-w-[160px]">
            <label for="kategori" class="mb-2 block text-sm font-semibold">Kategori</label>
            <select id="kategori" name="kategori"
                    class="w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F]">
                <option value="">Semua Kategori</option>
                @foreach ($kategoris as $kat)
                    <option value="{{ $kat->id }}" @selected($kategori == $kat->id)>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="min-w-[150px]">
            <label for="prioritas" class="mb-2 block text-sm font-semibold">Prioritas</label>
            <select id="prioritas" name="prioritas"
                    class="w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F]">
                <option value="">Semua Prioritas</option>
                <option value="tinggi" @selected($prioritas === 'tinggi')>Tinggi</option>
                <option value="sedang" @selected($prioritas === 'sedang')>Sedang</option>
                <option value="rendah" @selected($prioritas === 'rendah')>Rendah</option>
            </select>
        </div>

        <div class="min-w-[140px]">
            <label for="status" class="mb-2 block text-sm font-semibold">Status</label>
            <select id="status" name="status"
                    class="w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F]">
                <option value="">Semua Status</option>
                <option value="aktif"    @selected($status === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected($status === 'nonaktif')>Nonaktif</option>
            </select>
        </div>

        <button type="submit"
                class="rounded-xl bg-[#0F6B6F] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0A4F52]">
            Cari
        </button>

        <a href="{{ route('admin.kebutuhan.index') }}"
           class="rounded-xl border border-[#E8D9C8] px-5 py-3 text-sm font-semibold hover:bg-[#F6EBDD]">
            Reset
        </a>
    </form>
</div>

{{-- tabel --}}
<div class="overflow-hidden rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9]">

    <div class="border-b border-[#E8D9C8] px-6 py-5">
        <h2 class="text-lg font-bold text-[#0F6B6F]">Daftar Kebutuhan</h2>
        <p class="mt-1 text-sm text-[#7A6E66]">Total {{ $kebutuhan->total() }} data ditemukan</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">

            <thead class="bg-[#F6EBDD] text-[#4A403A]">
                <tr>
                    <th class="px-5 py-4 font-semibold">No.</th>
                    <th class="px-5 py-4 font-semibold">Nama Kebutuhan</th>
                    <th class="px-5 py-4 font-semibold">Kategori</th>
                    <th class="px-5 py-4 font-semibold">Jumlah</th>
                    <th class="px-5 py-4 font-semibold">Prioritas</th>
                    <th class="px-5 py-4 font-semibold">Status</th>
                    <th class="px-5 py-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-[#E8D9C8]">

                @forelse ($kebutuhan as $item)

                    @php
                        $warnaPrioritas = match ($item->prioritas) {
                            'tinggi' => 'bg-red-100 text-red-700',
                            'sedang' => 'bg-amber-100 text-amber-700',
                            'rendah' => 'bg-blue-100 text-blue-700',
                            default  => 'bg-gray-100 text-gray-600',
                        };
                        $warnaStatus = $item->status_kebutuhan === 'aktif'
                            ? 'bg-green-100 text-green-800'
                            : 'bg-gray-200 text-gray-600';
                    @endphp

                    <tr class="transition hover:bg-[#FFF8F1] {{ $item->status_kebutuhan === 'nonaktif' ? 'opacity-60' : '' }}">

                        <td class="px-5 py-4">
                            {{ $kebutuhan->firstItem() + $loop->index }}
                        </td>

                        <td class="px-5 py-4 font-semibold">
                            {{ $item->nama_kebutuhan }}
                        </td>

                        <td class="px-5 py-4 text-[#7A6E66]">
                            {{ $item->kategori->nama_kategori ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            {{ number_format((float) $item->jumlah_dibutuhkan, 0, ',', '.') }}
                            <span class="text-[#7A6E66]">{{ $item->satuan }}</span>
                        </td>

                        <td class="px-5 py-4">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $warnaPrioritas }}">
                                {{ ucfirst($item->prioritas) }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $warnaStatus }}">
                                {{ ucfirst($item->status_kebutuhan) }}
                            </span>
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-3">

                                <a href="{{ route('admin.kebutuhan.show', $item) }}"
                                   class="font-medium text-[#0F6B6F] hover:underline">
                                    Detail
                                </a>

                                <a href="{{ route('admin.kebutuhan.edit', $item) }}"
                                   class="font-medium text-[#D95F2E] hover:underline">
                                    Edit
                                </a>

                                <form action="{{ route('admin.kebutuhan.destroy', $item) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus kebutuhan \\'{{ addslashes($item->nama_kebutuhan) }}\\'?\n\nKebutuhan yang sudah terkait riwayat donasi tidak dapat dihapus.')">
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
                            <p class="font-semibold text-[#4A403A]">Belum ada kebutuhan panti</p>
                            <p class="mt-2 text-sm text-[#7A6E66]">Tambahkan kebutuhan baru atau ubah filter pencarian</p>
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    @if ($kebutuhan->hasPages())
        <div class="border-t border-[#E8D9C8] px-6 py-5">
            {{ $kebutuhan->links() }}
        </div>
    @endif

</div>

@endsection
