<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SitusBudaya;
use App\Models\Kategori;
use App\Models\Ulasan; // Import Model Ulasan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan pengguna yang login

class Publik extends Controller
{
    /**
     * Tampilkan Halaman Beranda / Daftar Situs (Index Publik).
     */
    public function index(Request $request)
    {
        // Mendapatkan semua Kategori untuk filter
        $kategori = Kategori::all();
        
        // Query dasar Situs Budaya, eager load kategori dan ulasan untuk efisiensi
        $situsBudayaQuery = SitusBudaya::with(['kategori', 'ulasan'])
                                       ->orderBy('nama', 'asc');
        
        // Menerapkan Filter berdasarkan Kategori (jika ada)
        if ($request->has('kategori_id') && $request->kategori_id) {
            $situsBudayaQuery->where('kategori_id', $request->kategori_id);
        }

        // Menerapkan Pencarian (jika ada)
        if ($request->has('cari') && $request->cari) {
            $situsBudayaQuery->where('nama', 'like', '%' . $request->cari . '%');
        }
        
        // Paginasi: Tampilkan 10 situs per halaman
        $situsBudaya = $situsBudayaQuery->paginate(10);
        
        // Memanggil View: resources/views/publik/index.blade.php
        return view('publik.index', compact('situsBudaya', 'kategori'));
    }

    /**
     * Tampilkan Detail Satu Situs Budaya.
     * Menggunakan Route Model Binding untuk SitusBudaya
     */
    public function show(SitusBudaya $situsBudaya)
    {
        // Eager load semua relasi yang dibutuhkan di halaman detail:
        // kategori, foto, riwayat, dan ulasan (beserta data penggunanya)
        $situsBudaya->load(['kategori', 'foto', 'riwayat', 'ulasan.pengguna']);

        // Menghitung rating rata-rata
        $ratingRataRata = $situsBudaya->ulasan->avg('nilai');

        // Memanggil View: resources/views/publik/show.blade.php
        return view('publik.show', compact('situsBudaya', 'ratingRataRata'));
    }

    /**
     * Proses penyimpanan Ulasan dari pengguna yang sudah login.
     * Terhubung ke route: ulasan.store (dilindungi middleware 'auth')
     */
    public function storeUlasan(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'situs_budaya_id' => 'required|exists:situs_budaya,id',
            'nilai' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        // 2. Cek apakah pengguna sudah pernah mengulas situs ini (opsional)
        $existingReview = Ulasan::where('situs_budaya_id', $request->situs_budaya_id)
                                ->where('pengguna_id', Auth::id())
                                ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk situs ini.');
        }

        // 3. Simpan Ulasan
        Ulasan::create([
            'situs_budaya_id' => $request->situs_budaya_id,
            'pengguna_id' => Auth::id(), // Mengambil ID pengguna yang sedang login
            'nilai' => $request->nilai,
            'komentar' => $request->komentar,
        ]);

        // 4. Redirect kembali ke halaman detail situs
        return back()->with('success', 'Ulasan Anda berhasil dikirim!');
    }
}