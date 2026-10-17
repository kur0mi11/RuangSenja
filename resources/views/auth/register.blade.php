@extends('auth.layout')

@section('title', 'Daftar Akun')
@section('meta_description', 'Buat akun donatur RuangSenja dan mulai berkontribusi untuk para lansia di panti jompo.')

@push('styles')
<style>
    /* Overrides khusus halaman register karena lebih panjang */
    .auth-form-panel { justify-content: flex-start; padding-top: var(--space-10); padding-bottom: var(--space-10); }
    .auth-form-container { max-width: 460px; margin-top: var(--space-10);}
</style>
@endpush

@section('content')
<div class="auth-wrapper">
    {{-- Panel Kiri: Branding --}}
    <div class="auth-brand">
        <div class="auth-brand-inner">
            <div class="auth-logo">
                <div class="auth-logo-icon">🌇</div>
                <span class="auth-logo-text">RuangSenja</span>
            </div>
            <p class="auth-brand-eyebrow">Daftar sebagai Donatur</p>
            <h1 class="auth-brand-heading">
                Hadirkan Kehangatan,<br>Penuhi Kebutuhan<br>Lansia.
            </h1>
            <p class="auth-brand-desc">
                Dengan mendaftar, kamu dapat melihat daftar kebutuhan panti, mengajukan donasi, dan memantau status pengajuanmu kapan saja.
            </p>
            <div class="auth-brand-stats" style="margin-top: var(--space-10);">
                <div class="auth-stat">
                    <div class="auth-stat-number">🎁</div>
                    <div class="auth-stat-label">Donasi Barang</div>
                </div>
                <div class="auth-stat">
                    <div class="auth-stat-number">💳</div>
                    <div class="auth-stat-label">Donasi Uang</div>
                </div>
                <div class="auth-stat">
                    <div class="auth-stat-number">📋</div>
                    <div class="auth-stat-label">Pantau Status</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Panel Kanan: Form Register --}}
    <div class="auth-form-panel">
        <div class="auth-form-container">
            <div class="auth-form-header">
                <h2 class="auth-form-title">Buat Akun Baru</h2>
                <p class="auth-form-subtitle">Isi informasi berikut untuk mendaftar sebagai donatur.</p>
            </div>

            {{-- Error umum --}}
            @if ($errors->any() && !$errors->has('email'))
                <div class="alert alert-danger" role="alert">
                    <span>✕</span>
                    <div>
                        <strong>Terdapat kesalahan pada formulir:</strong>
                        <ul style="margin-top:4px; padding-left:16px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if ($errors->has('email'))
                <div class="alert alert-danger" role="alert">
                    <span>✕</span> {{ $errors->first('email') }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('register.post') }}" novalidate>
                @csrf

                {{-- Nama --}}
                <div class="form-group">
                    <label class="form-label" for="nama">Nama Lengkap <span style="color:var(--color-danger)">*</span></label>
                    <input
                        class="form-input {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama') }}"
                        placeholder="Contoh: Bachtiar Nugraha"
                        autocomplete="name"
                        required
                    >
                    @error('nama')
                        <p class="form-error">✕ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email <span style="color:var(--color-danger)">*</span></label>
                    <input
                        class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="email"
                        required
                    >
                    @error('email')
                        <p class="form-error">✕ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Password + Konfirmasi --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="password">Password <span style="color:var(--color-danger)">*</span></label>
                        <div class="input-wrapper">
                            <input
                                class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Min. 8 karakter"
                                autocomplete="new-password"
                                required
                                oninput="checkStrength(this.value)"
                            >
                            <button type="button" class="btn-toggle-password" onclick="togglePassword('password')" aria-label="Tampilkan password">👁</button>
                        </div>
                        @error('password')
                            <p class="form-error">✕ {{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password <span style="color:var(--color-danger)">*</span></label>
                        <div class="input-wrapper">
                            <input
                                class="form-input"
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                autocomplete="new-password"
                                required
                            >
                            <button type="button" class="btn-toggle-password" onclick="togglePassword('password_confirmation')" aria-label="Tampilkan konfirmasi password">👁</button>
                        </div>
                    </div>
                </div>

                {{-- No HP (opsional) --}}
                <div class="form-group">
                    <label class="form-label" for="no_hp">Nomor HP <span class="form-hint" style="font-weight:400">(opsional)</span></label>
                    <input
                        class="form-input {{ $errors->has('no_hp') ? 'is-invalid' : '' }}"
                        type="tel"
                        id="no_hp"
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        placeholder="Contoh: 08123456789"
                        autocomplete="tel"
                    >
                    @error('no_hp')
                        <p class="form-error">✕ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat (opsional) --}}
                <div class="form-group">
                    <label class="form-label" for="alamat">Alamat <span class="form-hint" style="font-weight:400">(opsional)</span></label>
                    <textarea
                        class="form-textarea {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                        id="alamat"
                        name="alamat"
                        placeholder="Contoh: Jl. Merdeka No. 10, Bandung"
                        rows="2"
                    >{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="form-error">✕ {{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" id="btn-register" class="btn btn-primary" style="margin-top: var(--space-2);">
                    Buat Akun
                </button>
            </form>

            <p class="auth-footer-text" style="margin-top: var(--space-5);">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
