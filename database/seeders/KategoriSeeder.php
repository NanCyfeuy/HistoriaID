<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori; // Pastikan Model Kategori di-import

class KategoriSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        $dataKategori = [
            ['nama' => 'Benteng'],
            ['nama' => 'Candi'],
            ['nama' => 'Museum'],
            ['nama' => 'Situs Prasejarah'],
            ['nama' => 'Bangunan Kolonial'],
            ['nama' => 'Makam Kuno'],
        ];

        foreach ($dataKategori as $kategori) {
            Kategori::create($kategori);
        }
    }
}