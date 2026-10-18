@php
    $isEdit = isset($kebutuhan);
    $inputClass = 'w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F] focus:ring-2 focus:ring-[#0F6B6F]/10';
    $labelClass = 'mb-2 block text-sm font-semibold text-[#4A403A]';
@endphp

<form
    action="{{ $isEdit ? route('admin.kebutuhan.update', $kebutuhan) : route('admin.kebutuhan.store') }}"
    method="POST"
    class="space-y-6"
>
    @csrf

    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        {{-- nama kebutuhan --}}
        <div class="md:col-span-2">
            <label for="nama_kebutuhan" class="{{ $labelClass }}">
                Nama Kebutuhan <span class="text-red-600">*</span>
            </label>

            <input
                type="text"
                id="nama_kebutuhan"
                name="nama_kebutuhan"
                value="{{ old('nama_kebutuhan', $kebutuhan->nama_kebutuhan ?? '') }}"
                maxlength="150"
                required
                class="{{ $inputClass }}"
                placeholder="Contoh: Beras, Pampers Dewasa, Kursi Roda..."
            >

            @error('nama_kebutuhan')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- kategori --}}
        <div>
            <label for="kategori_id" class="{{ $labelClass }}">
                Kategori <span class="text-red-600">*</span>
            </label>

            <select
                id="kategori_id"
                name="kategori_id"
                required
                class="{{ $inputClass }}"
            >
                <option value="">Pilih kategori</option>
                @foreach ($kategoris as $kat)
                    <option
                        value="{{ $kat->id }}"
                        @selected(old('kategori_id', $kebutuhan->kategori_id ?? '') == $kat->id)
                    >
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>

            @error('kategori_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- prioritas --}}
        <div>
            <label for="prioritas" class="{{ $labelClass }}">
                Prioritas <span class="text-red-600">*</span>
            </label>

            <select
                id="prioritas"
                name="prioritas"
                required
                class="{{ $inputClass }}"
            >
                @foreach (['rendah' => 'Rendah', 'sedang' => 'Sedang', 'tinggi' => 'Tinggi'] as $value => $label)
                    <option
                        value="{{ $value }}"
                        @selected(old('prioritas', $kebutuhan->prioritas ?? 'sedang') === $value)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            @error('prioritas')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- jumlah dibutuhkan --}}
        <div>
            <label for="jumlah_dibutuhkan" class="{{ $labelClass }}">
                Jumlah Dibutuhkan <span class="text-red-600">*</span>
            </label>

            <input
                type="number"
                id="jumlah_dibutuhkan"
                name="jumlah_dibutuhkan"
                value="{{ old('jumlah_dibutuhkan', $kebutuhan->jumlah_dibutuhkan ?? '') }}"
                min="0.01"
                step="0.01"
                required
                class="{{ $inputClass }}"
                placeholder="Contoh: 50"
            >

            @error('jumlah_dibutuhkan')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- satuan --}}
        <div>
            <label for="satuan" class="{{ $labelClass }}">
                Satuan <span class="text-red-600">*</span>
            </label>

            <input
                type="text"
                id="satuan"
                name="satuan"
                value="{{ old('satuan', $kebutuhan->satuan ?? '') }}"
                maxlength="30"
                required
                class="{{ $inputClass }}"
                placeholder="Contoh: kg, pcs, dus, lusin..."
            >

            @error('satuan')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- status kebutuhan --}}
        <div>
            <label for="status_kebutuhan" class="{{ $labelClass }}">
                Status <span class="text-red-600">*</span>
            </label>

            <select
                id="status_kebutuhan"
                name="status_kebutuhan"
                required
                class="{{ $inputClass }}"
            >
                @foreach (['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'] as $value => $label)
                    <option
                        value="{{ $value }}"
                        @selected(old('status_kebutuhan', $kebutuhan->status_kebutuhan ?? 'aktif') === $value)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            @error('status_kebutuhan')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($isEdit)
                <p class="mt-2 text-xs text-[#7A6E66]">
                    Kebutuhan nonaktif tidak akan ditampilkan kepada donatur dan tidak dapat dipilih untuk pengajuan baru.
                </p>
            @endif
        </div>

        {{-- deskripsi --}}
        <div class="md:col-span-2">
            <label for="deskripsi" class="{{ $labelClass }}">
                Deskripsi
            </label>

            <textarea
                id="deskripsi"
                name="deskripsi"
                rows="4"
                class="{{ $inputClass }}"
                placeholder="Tambahkan penjelasan atau keterangan kebutuhan ini..."
            >{{ old('deskripsi', $kebutuhan->deskripsi ?? '') }}</textarea>

            @error('deskripsi')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- tombol aksi --}}
    <div class="flex flex-wrap justify-end gap-3 border-t border-[#E8D9C8] pt-6">

        <a
            href="{{ route('admin.kebutuhan.index') }}"
            class="rounded-xl border border-[#E8D9C8] px-6 py-3 text-sm font-semibold transition hover:bg-[#F6EBDD]"
        >
            Batal
        </a>

        <button
            type="submit"
            class="rounded-xl bg-[#0F6B6F] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#0A4F52]"
        >
            {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Kebutuhan' }}
        </button>

    </div>
</form>
