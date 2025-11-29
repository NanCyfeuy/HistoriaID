<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SitusBudaya;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; 

class Admin extends Controller
{
    /**
     * Tampilkan Dashboard Admin.
     */
    public function index()
    {
        // Logika untuk menampilkan statistik dashboard
        $totalSitus = SitusBudaya::count();
        $totalKategori = Kategori::count();
        
        return view('admin.dashboard', compact('totalSitus', 'totalKategori'));
    }

    /*
    |--------------------------------------------------------------------------
    | CRUD Situs Budaya
    |--------------------------------------------------------------------------
    */

    /**
     * Tampilkan daftar Situs Budaya (READ - Index).
     */
    public function situsBudayaIndex()
    {
        // Eager loading relasi 'kategori' untuk menghindari N+1 query problem
        $situsBudaya = SitusBudaya::with('kategori')->orderBy('nama', 'asc')->get();
        
        return view('admin.situs-budaya.index', compact('situsBudaya'));
    }

    /**
     * Tampilkan form untuk membuat Situs Budaya baru (CREATE).
     */
    public function situsBudayaCreate()
    {
        // Ambil semua kategori untuk mengisi dropdown pada formulir
        $kategori = Kategori::all();
        
        return view('admin.situs-budaya.create', compact('kategori'));
    }

    /**
     * Simpan data Situs Budaya baru ke database (STORE).
     */
    public function situsBudayaStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:situs_budaya,nama', // Tambah unique
            'deskripsi' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'lokasi_teks' => 'required|string',
            'lintang' => 'required|numeric',
            'bujur' => 'required|numeric',
            'tahun_berdiri' => 'nullable|integer',
        ]);
        
        $validated['slug'] = Str::slug($validated['nama']);
        SitusBudaya::create($validated);

        return redirect()->route('admin.situs-budaya.index')
                         ->with('success', 'Data situs budaya berhasil ditambahkan!');
    }
    
    /**
     * Menampilkan detail satu Situs Budaya (SHOW).
     */
    public function situsBudayaShow(SitusBudaya $situsBudaya)
    {
        // Memuat relasi yang mungkin dibutuhkan di tampilan show
        $situsBudaya->load(['kategori', 'foto', 'riwayat']); 
        
        return view('admin.situs-budaya.show', compact('situsBudaya'));
    }

    /**
     * Tampilkan form untuk mengedit Situs Budaya (EDIT).
     */
    public function situsBudayaEdit(SitusBudaya $situsBudaya)
    {
        $kategori = Kategori::all();
        
        // Memanggil View: resources/views/admin/situs-budaya/edit.blade.php
        return view('admin.situs-budaya.edit', compact('situsBudaya', 'kategori'));
    }

    /**
     * Perbarui data Situs Budaya di database (UPDATE).
     */
    public function situsBudayaUpdate(Request $request, SitusBudaya $situsBudaya)
    {
        $validated = $request->validate([
            // Tambahkan pengecualian untuk nama situs itu sendiri saat update
            'nama' => 'required|string|max:255|unique:situs_budaya,nama,' . $situsBudaya->id, 
            'deskripsi' => 'required|string',
            'kategori_id' => 'required|exists:kategori,id',
            'lokasi_teks' => 'required|string',
            'lintang' => 'required|numeric',
            'bujur' => 'required|numeric',
            'tahun_berdiri' => 'nullable|integer',
        ]);
        
        $validated['slug'] = Str::slug($validated['nama']);
        $situsBudaya->update($validated);

        return redirect()->route('admin.situs-budaya.index')
                         ->with('success', 'Data situs budaya berhasil diperbarui!');
    }

    /**
     * Hapus Situs Budaya dari database (DESTROY).
     */
    public function situsBudayaDestroy(SitusBudaya $situsBudaya)
    {
        $situsBudaya->delete();

        return redirect()->route('admin.situs-budaya.index')
                         ->with('success', 'Data situs budaya berhasil dihapus!');
    }
}