{{-- ── Header profil ────────────────────────────────────────────── --}}
<div class="mb-8 flex flex-wrap items-center gap-5">
    {{-- Avatar besar --}}
    <div class="flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-2xl
                {{ $pengguna->isAdmin() ? 'bg-[#CFE8E6] text-[#0A4F52]' : 'bg-[#FFD2B2] text-[#C4521A]' }}
                text-3xl font-extrabold shadow-sm">
        {{ strtoupper(substr($pengguna->nama ?? '?', 0, 1)) }}
    </div>

    <div>
        <h1 class="text-2xl font-extrabold text-[#0A4F52]">{{ $pengguna->nama }}</h1>
        <p class="mt-1 text-sm text-[#7A6E66]">
            <span class="inline-flex items-center gap-1.5 rounded-full
                         {{ $pengguna->isAdmin() ? 'bg-[#CFE8E6] text-[#0A4F52]' : 'bg-[#FFD2B2] text-[#C4521A]' }}
                         px-3 py-0.5 text-xs font-semibold">
                {{ $pengguna->isAdmin() ? 'Administrator' : 'Donatur' }}
            </span>
            <span class="ml-2 text-[#B5A79C]">Bergabung {{ $pengguna->created_at?->format('d M Y') ?? '-' }}</span>
        </p>
    </div>
</div>

{{-- ── Statistik donasi (khusus donatur) ──────────────────────── --}}
@if(!$pengguna->isAdmin() && isset($ringkasan))
<div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    @php
        $stats = [
            ['label' => 'Total Donasi',  'value' => $ringkasan['total'],    'color' => 'text-[#0F6B6F]'],
            ['label' => 'Menunggu',      'value' => $ringkasan['menunggu'], 'color' => 'text-[#E8A33B]'],
            ['label' => 'Diterima',      'value' => $ringkasan['diterima'], 'color' => 'text-[#6FA77B]'],
            ['label' => 'Ditolak',       'value' => $ringkasan['ditolak'],  'color' => 'text-[#D96C6C]'],
        ];
    @endphp
    @foreach($stats as $s)
        <div class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5">
            <p class="text-sm text-[#7A6E66]">{{ $s['label'] }}</p>
            <p class="mt-1 text-3xl font-extrabold {{ $s['color'] }}">{{ $s['value'] }}</p>
        </div>
    @endforeach
</div>
@endif

{{-- ── Dua kartu: Data Diri + Ganti Password ───────────────────── --}}
<div class="grid gap-6 lg:grid-cols-2">

    {{-- Kartu Data Diri --}}
    <form method="POST" action="{{ route($updateRoute) }}"
          class="rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <h2 class="text-lg font-bold text-[#0A4F52]">Data Diri</h2>
            <p class="mt-1 text-sm text-[#7A6E66]">Perbarui informasi profil Anda.</p>
        </div>

        {{-- Validation errors untuk data diri --}}
        @if ($errors->hasAny(['nama','email','no_hp','alamat']))
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-inside list-disc space-y-1">
                    @foreach (['nama','email','no_hp','alamat'] as $f)
                        @error($f)<li>{{ $message }}</li>@enderror
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-4">
            <div>
                <label for="nama" class="mb-1 block text-sm font-semibold">Nama Lengkap</label>
                <input id="nama" type="text" name="nama"
                       value="{{ old('nama', $pengguna->nama) }}"
                       required maxlength="100"
                       class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm
                              focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]
                              @error('nama') border-red-400 @enderror">
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-semibold">Email</label>
                <input id="email" type="email" name="email"
                       value="{{ old('email', $pengguna->email) }}"
                       required maxlength="150"
                       class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm
                              focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]
                              @error('email') border-red-400 @enderror">
            </div>

            <div>
                <label for="no_hp" class="mb-1 block text-sm font-semibold">No. HP</label>
                <input id="no_hp" type="text" name="no_hp"
                       value="{{ old('no_hp', $pengguna->no_hp) }}"
                       maxlength="20" placeholder="08xxxxxxxxxx"
                       class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm
                              focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]
                              @error('no_hp') border-red-400 @enderror">
            </div>

            <div>
                <label for="alamat" class="mb-1 block text-sm font-semibold">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" maxlength="500"
                          class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm
                                 focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]
                                 @error('alamat') border-red-400 @enderror">{{ old('alamat', $pengguna->alamat) }}</textarea>
            </div>
        </div>

        <button type="submit"
                class="mt-6 rounded-xl bg-[#0F6B6F] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#0A4F52]">
            Simpan Perubahan
        </button>
    </form>

    {{-- Kartu Ganti Password --}}
    <form method="POST" action="{{ route($passwordRoute) }}"
          class="self-start rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-6">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <h2 class="text-lg font-bold text-[#0A4F52]">Ganti Password</h2>
            <p class="mt-1 text-sm text-[#7A6E66]">Gunakan minimal 8 karakter.</p>
        </div>

        {{-- Validation errors untuk password --}}
        @if ($errors->hasAny(['password_lama','password','password_confirmation']))
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-inside list-disc space-y-1">
                    @foreach (['password_lama','password','password_confirmation'] as $f)
                        @error($f)<li>{{ $message }}</li>@enderror
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-4">
            <div>
                <label for="password_lama" class="mb-1 block text-sm font-semibold">Password Lama</label>
                <input id="password_lama" type="password" name="password_lama"
                       required autocomplete="current-password"
                       class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm
                              focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]
                              @error('password_lama') border-red-400 @enderror">
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-semibold">Password Baru</label>
                <input id="password" type="password" name="password"
                       required minlength="8" autocomplete="new-password"
                       class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm
                              focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]
                              @error('password') border-red-400 @enderror">
            </div>

            <div>
                <label for="password_confirmation" class="mb-1 block text-sm font-semibold">Konfirmasi Password Baru</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       required minlength="8" autocomplete="new-password"
                       class="w-full rounded-xl border border-[#D9C4B3] bg-white px-4 py-3 text-sm
                              focus:border-[#0F6B6F] focus:outline-none focus:ring-2 focus:ring-[#CFE8E6]">
            </div>
        </div>

        <button type="submit"
                class="mt-6 rounded-xl bg-[#F47C4C] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#D95F2E]">
            Ganti Password
        </button>
    </form>

</div>
