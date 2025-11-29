<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin; 
use App\Http\Controllers\Publik;
use App\Http\Controllers\AuthController;
// Pastikan path ke Controller Anda sudah benar

/*
|--------------------------------------------------------------------------
| Route Autentikasi Manual
|--------------------------------------------------------------------------
*/

// Tampilkan Formulir Login (GET) - HARUS ada nama 'login'
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');

// Proses Login (POST)
Route::post('login', [AuthController::class, 'login']);

// Proses Logout (POST)
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Route Administrasi (Membutuhkan Login)
|--------------------------------------------------------------------------
*/

// Kelompok Route yang hanya bisa diakses oleh pengguna yang sudah login
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/', [Admin::class, 'index'])->name('admin.dashboard');
    
    // --- Route CRUD Situs Budaya ---

    // READ (Daftar)
    Route::get('situs-budaya', [Admin::class, 'situsBudayaIndex'])->name('admin.situs-budaya.index');
    
    // CREATE (Form Tambah)
    Route::get('situs-budaya/tambah', [Admin::class, 'situsBudayaCreate'])->name('admin.situs-budaya.create');
    
    // STORE (Simpan Data Baru)
    Route::post('situs-budaya/simpan', [Admin::class, 'situsBudayaStore'])->name('admin.situs-budaya.store');

    // SHOW (Detail Situs) - Menggunakan Route Model Binding
    Route::get('situs-budaya/{situsBudaya}', [Admin::class, 'situsBudayaShow'])->name('admin.situs-budaya.show');

    // EDIT (Form Edit) - Menggunakan Route Model Binding
    Route::get('situs-budaya/{situsBudaya}/edit', [Admin::class, 'situsBudayaEdit'])->name('admin.situs-budaya.edit');

    // UPDATE (Update Data) - Menggunakan Route Model Binding
    Route::put('situs-budaya/{situsBudaya}', [Admin::class, 'situsBudayaUpdate'])->name('admin.situs-budaya.update');

    // DESTROY (Hapus Data) - Menggunakan Route Model Binding
    Route::delete('situs-budaya/{situsBudaya}', [Admin::class, 'situsBudayaDestroy'])->name('admin.situs-budaya.destroy');
});


/*
|--------------------------------------------------------------------------
| Route Publik (Pengguna Umum)
|--------------------------------------------------------------------------
*/

// Halaman Beranda
Route::get('/', [Publik::class, 'index'])->name('public.index');
    
// Detail Situs
Route::get('situs/{slug}', [Publik::class, 'show'])->name('situs.show');

// Pengiriman Ulasan (Wajib Login)
Route::post('ulasan', [Publik::class, 'storeUlasan'])->middleware('auth')->name('ulasan.store');