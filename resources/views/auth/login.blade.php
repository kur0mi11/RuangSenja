@extends('auth.layout')

@section('title', 'Masuk')
@section('meta_description', 'Masuk ke akun RuangSenja Anda untuk mengelola donasi dan kebutuhan panti jompo.')

@section('content')
<div class="auth-wrapper">
    {{-- Panel Kiri: Branding --}}
    <div class="auth-brand">
        <div class="auth-brand-inner">
            <div class="auth-logo">
                <div class="auth-logo-icon">🌇</div>
                <span class="auth-logo-text">RuangSenja</span>
            </div>
            <p class="auth-brand-eyebrow">Platform Donasi Panti Jompo</p>
            <h1 class="auth-brand-heading">
                Kepedulian yang<br>Menghadirkan<br>Kehangatan.
            </h1>
            <p class="auth-brand-desc">
                Bergabunglah dan bantu penuhi kebutuhan para lansia di panti jompo. Setiap donasi, besar maupun kecil, sangat berarti bagi mereka.
            </p>
            <div class="auth-brand-stats">
                <div class="auth-stat">
                    <div class="auth-stat-number">❤️</div>
                    <div class="auth-stat-label">Penuh Empati</div>
                </div>
                <div class="auth-stat">
                    <div class="auth-stat-number">🔒</div>
                    <div class="auth-stat-label">Aman & Terpercaya</div>
                </div>
                <div class="auth-stat">
                    <div class="auth-stat-number">✅</div>
                    <div class="auth-stat-label">Transparan</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Panel Kanan: Form Login --}}
    <div class="auth-form-panel">
        <div class="auth-form-container">
            <div class="auth-form-header">
                <h2 class="auth-form-title">Selamat datang kembali</h2>
                <p class="auth-form-subtitle">Masuk untuk melanjutkan aktivitas donasimu.</p>
            </div>

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <span>✓</span> {{ session('success') }}
                </div>
            @endif

            @if ($errors->has('email') && !$errors->has('nama'))
                <div class="alert alert-danger" role="alert">
                    <span>✕</span> {{ $errors->first('email') }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.post') }}" novalidate>
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
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
                </div>

                <div class="form-group">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:var(--space-2);">
                        <label class="form-label" for="password" style="margin-bottom:0;">Password</label>
                    </div>
                    <div class="input-wrapper">
                        <input
                            class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password kamu"
                            autocomplete="current-password"
                            required
                        >
                        <button
                            type="button"
                            class="btn-toggle-password"
                            onclick="togglePassword('password')"
                            aria-label="Tampilkan password"
                        >👁</button>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="remember"
                            name="remember"
                        >
                        <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
                    </div>
                </div>

                <button type="submit" id="btn-login" class="btn btn-primary">
                    Masuk ke Akun
                </button>
            </form>

            <div class="auth-divider">atau</div>

            <p class="auth-footer-text">
                Belum punya akun?
                <a href="{{ route('register') }}" class="auth-link">Daftar sebagai Donatur</a>
            </p>
        </div>
    </div>
</div>
@endsection
