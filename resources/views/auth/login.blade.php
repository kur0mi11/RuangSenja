@extends('auth.layout')

@section('title', 'Masuk')
@section('meta_description', 'Masuk ke akun RuangSenja Anda untuk mengelola donasi dan kebutuhan panti jompo.')

@section('content')
<div class="auth-wrapper">
    {{-- Panel Kiri: Branding --}}
    <div class="auth-brand">
        <div class="auth-brand-inner">
            <div class="auth-logo">
                <div class="auth-logo-icon">RS</div>
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
                    <div class="auth-stat-number">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg> -->
                    </div>
                    <div class="auth-stat-label">Penuh Empati</div>
                </div>
                <div class="auth-stat">
                    <div class="auth-stat-number">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg> -->
                    </div>
                    <div class="auth-stat-label">Aman &amp; Terpercaya</div>
                </div>
                <div class="auth-stat">
                    <div class="auth-stat-number">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> -->
                    </div>
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
                    <span class="alert-icon">🎉</span>
                    <div>
                        <strong style="display:block; font-weight:700; margin-bottom:2px;">Aksi Berhasil!</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if ($errors->has('email') && !$errors->has('nama'))
                <div class="alert alert-danger" role="alert">
                    <span class="alert-icon">⚠️</span>
                    <div>
                        <strong style="display:block; font-weight:700; margin-bottom:2px;">Gagal Masuk</strong>
                        <span>{{ $errors->first('email') }}</span>
                    </div>
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
