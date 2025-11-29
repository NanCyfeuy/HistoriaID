<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna; // Menggunakan Model Pengguna yang sudah kita buat
use Illuminate\Support\Facades\Hash; // Wajib untuk mengenkripsi kata sandi

class AdminSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        // 1. Akun Administrator Utama
        Pengguna::create([
            'nama' => 'Admin Utama Historia',
            'email' => 'admin@historiaid.com',
            // Kata sandi dienkripsi, nilai plaintext-nya adalah: password
            'kata_sandi' => Hash::make('password'), 
            'peran' => 'admin', // PENTING: Untuk hak akses penuh ke dashboard
        ]);

        // 2. Akun Pengguna Biasa (untuk menguji fitur ulasan/reviewer)
        Pengguna::create([
            'nama' => 'Pengguna Ulasan',
            'email' => 'user@historiaid.com',
            'kata_sandi' => Hash::make('password'), 
            'peran' => 'pengguna',
        ]);
        
        // 3. Tambahkan 5 pengguna dummy lagi menggunakan Factory (jika tersedia)
        // Ini memastikan tabel pengguna memiliki data yang cukup untuk diuji.
        // if (class_exists(\App\Models\Pengguna::class) && method_exists(\App\Models\Pengguna::class, 'factory')) {
        //      \App\Models\Pengguna::factory()->count(5)->create(['peran' => 'pengguna']);
        // }
    }
}