@php
    $isEdit = isset($lansia);
    $inputClass = 'w-full rounded-xl border border-[#E8D9C8] bg-white px-4 py-3 text-sm outline-none focus:border-[#0F6B6F] focus:ring-2 focus:ring-[#0F6B6F]/10';
    $labelClass = 'mb-2 block text-sm font-semibold text-[#4A403A]';
@endphp

<form
    action="{{ $isEdit ? route('admin.lansia.update', $lansia) : route('admin.lansia.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="space-y-6"
>
    @csrf

    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <!-- nama lengkap -->
        <div class="md:col-span-2">
            <label for="nama_lengkap" class="{{ $labelClass }}">
                Nama Lengkap <span class="text-red-600">*</span>
            </label>

            <input
                type="text"
                id="nama_lengkap"
                name="nama_lengkap"
                value="{{ old('nama_lengkap', $lansia->nama_lengkap ?? '') }}"
                maxlength="150"
                required
                class="{{ $inputClass }}"
                placeholder="Masukkan nama lengkap lansia"
            >

            @error('nama_lengkap')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- tanggal lahir -->
        <div>
            <label for="tanggal_lahir" class="{{ $labelClass }}">
                Tanggal Lahir
            </label>

            <input
                type="date"
                id="tanggal_lahir"
                name="tanggal_lahir"
                value="{{ old('tanggal_lahir', isset($lansia) && $lansia->tanggal_lahir ? $lansia->tanggal_lahir->format('Y-m-d') : '') }}"
                max="{{ now()->toDateString() }}"
                class="{{ $inputClass }}"
            >

            @error('tanggal_lahir')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- jenis kelamin -->
        <div>
            <label for="jenis_kelamin" class="{{ $labelClass }}">
                Jenis Kelamin <span class="text-red-600">*</span>
            </label>

            <select
                id="jenis_kelamin"
                name="jenis_kelamin"
                required
                class="{{ $inputClass }}"
            >
                <option value="">Pilih jenis kelamin</option>

                <option value="laki-laki"
                    @selected(old('jenis_kelamin', $lansia->jenis_kelamin ?? '') === 'laki-laki')>
                    Laki-laki
                </option>

                <option value="perempuan"
                    @selected(old('jenis_kelamin', $lansia->jenis_kelamin ?? '') === 'perempuan')>
                    Perempuan
                </option>
            </select>

            @error('jenis_kelamin')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- nomor kamar -->
        <div>
            <label for="nomor_kamar" class="{{ $labelClass }}">
                Nomor Kamar
            </label>

            <input
                type="text"
                id="nomor_kamar"
                name="nomor_kamar"
                value="{{ old('nomor_kamar', $lansia->nomor_kamar ?? '') }}"
                maxlength="30"
                class="{{ $inputClass }}"
                placeholder="Contoh: A-101"
            >

            @error('nomor_kamar')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- tanggal masuk -->
        <div>
            <label for="tanggal_masuk" class="{{ $labelClass }}">
                Tanggal Masuk
            </label>

            <input
                type="date"
                id="tanggal_masuk"
                name="tanggal_masuk"
                value="{{ old('tanggal_masuk', isset($lansia) && $lansia->tanggal_masuk ? $lansia->tanggal_masuk->format('Y-m-d') : '') }}"
                max="{{ now()->toDateString() }}"
                class="{{ $inputClass }}"
            >

            @error('tanggal_masuk')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- status penghuni -->
        <div>
            <label for="status_penghuni" class="{{ $labelClass }}">
                Status Penghuni <span class="text-red-600">*</span>
            </label>

            <select
                id="status_penghuni"
                name="status_penghuni"
                required
                class="{{ $inputClass }}"
            >
                @foreach (['aktif' => 'Aktif', 'pindah' => 'Pindah', 'meninggal' => 'Meninggal'] as $value => $label)
                    <option
                        value="{{ $value }}"
                        @selected(old('status_penghuni', $lansia->status_penghuni ?? 'aktif') === $value)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            @error('status_penghuni')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- upload foto -->
        <div>
            <label for="foto" class="{{ $labelClass }}">
                Foto Lansia
            </label>

            <input
                type="file"
                id="foto"
                name="foto"
                accept=".jpg,.jpeg,.png,.webp"
                class="{{ $inputClass }}"
            >

            <p class="mt-2 text-xs text-[#7A6E66]">
                JPG, PNG, atau WebP. Maksimal 2 MB.
            </p>

            @if ($isEdit && $lansia->foto)
                <p class="mt-2 text-xs text-[#0F6B6F]">
                    Foto sudah tersimpan. Kosongkan jika tidak ingin menggantinya.
                </p>
            @endif

            @error('foto')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- keterangan -->
        <div class="md:col-span-2">
            <label for="keterangan" class="{{ $labelClass }}">
                Keterangan
            </label>

            <textarea
                id="keterangan"
                name="keterangan"
                rows="4"
                class="{{ $inputClass }}"
                placeholder="Tambahkan keterangan jika diperlukan"
            >{{ old('keterangan', $lansia->keterangan ?? '') }}</textarea>

            @error('keterangan')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- tombol aksi -->
    <div class="flex flex-wrap justify-end gap-3 border-t border-[#E8D9C8] pt-6">

        <a
            href="{{ route('admin.lansia.index') }}"
            class="rounded-xl border border-[#E8D9C8] px-6 py-3 text-sm font-semibold transition hover:bg-[#F6EBDD]"
        >
            Batal
        </a>

        <button
            type="submit"
            class="rounded-xl bg-[#0F6B6F] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#0A4F52]"
        >
            {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Lansia' }}
        </button>

    </div>
</form>