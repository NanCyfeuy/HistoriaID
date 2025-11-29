<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna; // Pastikan Model Pengguna Anda sudah benar

class AuthController extends Controller
{
    /**
     * Menampilkan formulir login.
     */
    public function showLoginForm()
    {
        // Jika pengguna sudah login, arahkan berdasarkan peran
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->peran === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('public.index');
        }
        
        // Memanggil View: resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Memproses percobaan login.
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            // Nama field di form adalah 'kata_sandi'
            'kata_sandi' => ['required'], 
        ]);
        
        // Mapping: Auth::attempt mencari kunci 'password', jadi kita petakan 'kata_sandi' ke 'password'
        $authCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['kata_sandi'],
        ];

        // 2. Mencoba proses autentikasi
        if (Auth::attempt($authCredentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->peran === 'admin') {
                // Redirect ke Dashboard Admin
                return redirect()->intended(route('admin.dashboard'));
            }

            // Redirect ke Beranda Publik
            return redirect()->intended(route('public.index'));
        }

        // 3. Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}