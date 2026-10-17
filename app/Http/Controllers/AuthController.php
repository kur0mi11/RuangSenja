<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Form Login
    /**
     * Tampilkan halaman login.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    /**
     * Proses permintaan login.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email', 'max:150'],
            'password' => ['required', 'string'],
        ]);

        // Cari pengguna berdasarkan email
        $pengguna = Pengguna::where('email', $credentials['email'])->first();

        // Periksa keberadaan akun, password, dan status aktif
        if (!$pengguna || !Hash::check($credentials['password'], $pengguna->password_hash)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password yang kamu masukkan salah.']);
        }

        if (!$pengguna->isAktif()) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Akun kamu tidak aktif. Hubungi admin untuk informasi lebih lanjut.']);
        }

        // Login pengguna
        Auth::login($pengguna, $request->boolean('remember'));
        $request->session()->regenerate();

        return $this->redirectByRole();
    }

    // Form Register
    /**
     * Tampilkan halaman registrasi.
     */
    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.register');
    }

    /**
     * Proses permintaan registrasi donatur baru.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', 'unique:pengguna,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'no_hp'    => ['nullable', 'string', 'max:20'],
            'alamat'   => ['nullable', 'string', 'max:500'],
        ], [
            'nama.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Registrasi publik hanya membuat akun donatur
        $pengguna = Pengguna::create([
            'nama'          => $validated['nama'],
            'email'         => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'no_hp'         => $validated['no_hp'] ?? null,
            'alamat'        => $validated['alamat'] ?? null,
            'role'          => 'donatur',
            'status_akun'   => 'aktif',
        ]);

        Auth::login($pengguna);
        $request->session()->regenerate();

        return redirect()->route('donatur.dashboard')
            ->with('success', 'Selamat datang di RuangSenja, ' . $pengguna->nama . '! Akun kamu berhasil dibuat.');
    }

    // Logout
    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Kamu berhasil keluar dari RuangSenja.');
    }

    // Helper
    /**
     * Arahkan pengguna ke dashboard sesuai perannya.
     */
    private function redirectByRole(): RedirectResponse
    {
        return Auth::user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('donatur.dashboard');
    }
}
