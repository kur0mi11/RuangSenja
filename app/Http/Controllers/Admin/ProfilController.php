<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfilController extends Controller
{
    /**
     * Halaman profil admin: data diri & ganti password.
     */
    public function index(Request $request): View
    {
        $pengguna = $request->user();

        return view('admin.profil.index', compact('pengguna'));
    }

    /**
     * Perbarui data diri admin.
     */
    public function update(Request $request): RedirectResponse
    {
        $pengguna = $request->user();

        $validated = $request->validate([
            'nama'   => ['required', 'string', 'max:100'],
            'email'  => ['required', 'email', 'max:150', Rule::unique('pengguna', 'email')->ignore($pengguna->id)],
            'no_hp'  => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [
            'nama.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email ini sudah dipakai akun lain.',
            'no_hp.regex'    => 'Nomor HP hanya boleh berisi angka, spasi, tanda + dan -.',
        ]);

        try {
            $pengguna->update($validated);
        } catch (\Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'Profil gagal diperbarui. Silakan coba lagi.');
        }

        return redirect()->route('admin.profil.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Ganti password admin.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $pengguna = $request->user();

        $request->validate([
            'password_lama' => ['required', 'string'],
            'password'      => ['required', 'string', 'min:8', 'confirmed', 'different:password_lama'],
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password.required'      => 'Password baru wajib diisi.',
            'password.min'           => 'Password baru minimal 8 karakter.',
            'password.confirmed'     => 'Konfirmasi password baru tidak cocok.',
            'password.different'     => 'Password baru harus berbeda dari password lama.',
        ]);

        if (!Hash::check($request->input('password_lama'), $pengguna->password_hash)) {
            return back()->withErrors(['password_lama' => 'Password lama yang kamu masukkan salah.']);
        }

        try {
            $pengguna->forceFill(['password_hash' => Hash::make($request->input('password'))])->save();
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Password gagal diganti. Silakan coba lagi.');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.profil.index')
            ->with('success', 'Password berhasil diganti.');
    }
}
