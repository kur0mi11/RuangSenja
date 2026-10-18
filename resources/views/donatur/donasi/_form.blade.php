@php
    $editing = isset($donasi);
    $tipeTerpilih = old('tipe_donasi', $editing ? $donasi->tipe_donasi : 'barang');
    $metodeTerpilih = old('metode_donasi', $editing ? $donasi->metode_donasi : 'langsung');
    $barisBarang = old('items', $editing
        ? $donasi->detailDonasi->map(fn ($detail) => $detail->only(['kebutuhan_id', 'jumlah', 'catatan_item']))->all()
        : [['kebutuhan_id' => '', 'jumlah' => '', 'catatan_item' => '']]);
@endphp

<form method="POST"
      action="{{ $editing ? route('donatur.donasi.update', $donasi) : route('donatur.donasi.store') }}"
      enctype="multipart/form-data"
      class="space-y-6">
    @csrf
    @if ($editing)
        @method('PUT')
    @endif

    <section class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 sm:p-6">
        <h2 class="mb-5 text-lg font-bold text-[#0F6B6F]">Informasi Donasi</h2>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="tipe_donasi" class="mb-2 block text-sm font-semibold">Jenis Donasi <span class="text-red-600">*</span></label>
                <select id="tipe_donasi" name="tipe_donasi" required class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3">
                    <option value="barang" @selected($tipeTerpilih === 'barang')>Barang</option>
                    <option value="uang" @selected($tipeTerpilih === 'uang')>Uang</option>
                </select>
            </div>
            <div>
                <label for="metode_donasi" class="mb-2 block text-sm font-semibold">Metode Donasi <span class="text-red-600">*</span></label>
                <select id="metode_donasi" name="metode_donasi" required class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3">
                    <option value="langsung" data-tipe="barang uang" @selected($metodeTerpilih === 'langsung')>Langsung</option>
                    <option value="pengiriman" data-tipe="barang" @selected($metodeTerpilih === 'pengiriman')>Pengiriman</option>
                    <option value="transfer" data-tipe="uang" @selected($metodeTerpilih === 'transfer')>Transfer</option>
                </select>
            </div>
        </div>
    </section>

    <fieldset id="bagian-barang" @disabled($tipeTerpilih !== 'barang')
              class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 sm:p-6 disabled:opacity-60">
        <legend class="px-2 text-lg font-bold text-[#0F6B6F]">Rincian Barang</legend>
        <p class="mb-4 text-sm text-[#7A6E66]">Pilih kebutuhan yang aktif. Satuan akan mengikuti data kebutuhan panti.</p>
        <div id="daftar-barang" class="space-y-4">
            @foreach ($barisBarang as $index => $baris)
                <div class="baris-barang grid gap-3 rounded-xl border border-[#E8D9C8] p-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="sm:col-span-2 lg:col-span-2">
                        <label class="mb-2 block text-sm font-semibold">Kebutuhan <span class="text-red-600">*</span></label>
                        <select name="items[{{ $index }}][kebutuhan_id]" required class="w-full rounded-lg border border-[#D9C4B3] bg-white px-3 py-2.5">
                            <option value="">Pilih kebutuhan</option>
                            @foreach ($kebutuhan as $need)
                                <option value="{{ $need->id }}" @selected((string) data_get($baris, 'kebutuhan_id') === (string) $need->id)>
                                    {{ $need->nama_kebutuhan }} ({{ $need->kategori?->nama_kategori ?? '-' }}) — {{ $need->satuan }}{{ $need->status_kebutuhan !== 'aktif' ? ' · tidak aktif, hanya untuk item yang sudah dipilih' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold">Jumlah <span class="text-red-600">*</span></label>
                        <input type="number" name="items[{{ $index }}][jumlah]" min="0.01" step="0.01" value="{{ data_get($baris, 'jumlah') }}" required class="w-full rounded-lg border border-[#D9C4B3] px-3 py-2.5">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold">Catatan item</label>
                        <input type="text" name="items[{{ $index }}][catatan_item]" maxlength="255" value="{{ data_get($baris, 'catatan_item') }}" class="w-full rounded-lg border border-[#D9C4B3] px-3 py-2.5">
                    </div>
                    <div class="sm:col-span-2 lg:col-span-4">
                        <button type="button" class="hapus-barang text-sm font-semibold text-red-700 hover:underline">Hapus item</button>
                    </div>
                </div>
            @endforeach
        </div>
        <button id="tambah-barang" type="button" class="mt-4 rounded-lg border border-[#0F6B6F] px-4 py-2 text-sm font-semibold text-[#0F6B6F] hover:bg-[#EAF5F3]">+ Tambah kebutuhan</button>
    </fieldset>

    <fieldset id="bagian-uang" @disabled($tipeTerpilih !== 'uang')
              class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 sm:p-6 disabled:opacity-60">
        <legend class="px-2 text-lg font-bold text-[#0F6B6F]">Donasi Uang</legend>
        <label for="nominal" class="mb-2 block text-sm font-semibold">Nominal (Rp) <span class="text-red-600">*</span></label>
        <input id="nominal" type="number" name="nominal" min="0.01" step="0.01" value="{{ old('nominal', $editing ? $donasi->nominal : '') }}" required class="w-full max-w-md rounded-xl border border-[#D9C4B3] px-4 py-3">
        @if ($editing && $donasi->bukti_transfer)
            <p class="mt-3 text-sm text-[#7A6E66]">Bukti transfer saat ini sudah tersimpan. Unggah file baru untuk menggantinya.</p>
        @endif
        <div id="bagian-bukti" class="mt-5">
            <label for="bukti_transfer" class="mb-2 block text-sm font-semibold">Bukti transfer (opsional, JPG/PNG/PDF maks. 5 MB)</label>
            <input id="bukti_transfer" type="file" name="bukti_transfer" accept=".jpg,.jpeg,.png,.pdf" class="block w-full max-w-xl rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm">
        </div>
    </fieldset>

    <section class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 sm:p-6">
        <label for="catatan_donatur" class="mb-2 block text-sm font-semibold">Catatan untuk Admin</label>
        <textarea id="catatan_donatur" name="catatan_donatur" rows="4" maxlength="2000" class="w-full rounded-xl border border-[#D9C4B3] px-4 py-3">{{ old('catatan_donatur', $editing ? $donasi->catatan_donatur : '') }}</textarea>
    </section>

    <div class="flex flex-wrap items-center gap-3">
        <button type="submit" class="rounded-xl bg-[#0F6B6F] px-6 py-3 font-bold text-white hover:bg-[#0A4F52]">{{ $editing ? 'Simpan Perubahan' : 'Kirim Pengajuan' }}</button>
        <a href="{{ $editing ? route('donatur.donasi.show', $donasi) : route('donatur.donasi.index') }}" class="rounded-xl border border-[#D9C4B3] px-6 py-3 font-semibold hover:bg-[#F6EBDD]">Batal</a>
    </div>
</form>

<template id="template-barang">
    <div class="baris-barang grid gap-3 rounded-xl border border-[#E8D9C8] p-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="sm:col-span-2 lg:col-span-2">
            <label class="mb-2 block text-sm font-semibold">Kebutuhan <span class="text-red-600">*</span></label>
            <select data-field="kebutuhan_id" required class="w-full rounded-lg border border-[#D9C4B3] bg-white px-3 py-2.5">
                <option value="">Pilih kebutuhan</option>
                @foreach ($kebutuhan->where('status_kebutuhan', 'aktif') as $need)
                    <option value="{{ $need->id }}">{{ $need->nama_kebutuhan }} ({{ $need->kategori?->nama_kategori ?? '-' }}) — {{ $need->satuan }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Jumlah <span class="text-red-600">*</span></label>
            <input data-field="jumlah" type="number" min="0.01" step="0.01" required class="w-full rounded-lg border border-[#D9C4B3] px-3 py-2.5">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold">Catatan item</label>
            <input data-field="catatan_item" type="text" maxlength="255" class="w-full rounded-lg border border-[#D9C4B3] px-3 py-2.5">
        </div>
        <div class="sm:col-span-2 lg:col-span-4">
            <button type="button" class="hapus-barang text-sm font-semibold text-red-700 hover:underline">Hapus item</button>
        </div>
    </div>
</template>

<script>
    const donationType = document.getElementById('tipe_donasi');
    const method = document.getElementById('metode_donasi');
    const goods = document.getElementById('bagian-barang');
    const money = document.getElementById('bagian-uang');
    const proof = document.getElementById('bagian-bukti');
    const proofInput = document.getElementById('bukti_transfer');
    const rows = document.getElementById('daftar-barang');

    function updateDonationFields() {
        const isGoods = donationType.value === 'barang';
        goods.disabled = !isGoods;
        money.disabled = isGoods;
        method.querySelectorAll('option').forEach((option) => {
            const allowed = option.dataset.tipe.split(' ').includes(donationType.value);
            option.hidden = !allowed;
            option.disabled = !allowed;
        });
        if (method.selectedOptions.length && method.selectedOptions[0].disabled) {
            method.value = isGoods ? 'langsung' : 'langsung';
        }
        proof.hidden = donationType.value !== 'uang' || method.value !== 'transfer';
        proofInput.disabled = proof.hidden;
    }

    function addGoodsRow() {
        const fragment = document.getElementById('template-barang').content.cloneNode(true);
        const row = fragment.querySelector('.baris-barang');
        const index = Date.now() + Math.floor(Math.random() * 1000);
        row.querySelectorAll('[data-field]').forEach((field) => {
            field.name = `items[${index}][${field.dataset.field}]`;
        });
        rows.appendChild(fragment);
    }

    document.getElementById('tambah-barang').addEventListener('click', addGoodsRow);
    rows.addEventListener('click', (event) => {
        if (event.target.closest('.hapus-barang')) {
            const allRows = rows.querySelectorAll('.baris-barang');
            if (allRows.length > 1) {
                event.target.closest('.baris-barang').remove();
            }
        }
    });
    donationType.addEventListener('change', updateDonationFields);
    method.addEventListener('change', updateDonationFields);
    updateDonationFields();
</script>
