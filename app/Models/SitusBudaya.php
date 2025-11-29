<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitusBudaya extends Model
{
    use HasFactory;

    protected $table = 'situs_budaya';

    protected $fillable = [
        'kategori_id', 'nama', 'slug', 'deskripsi', 
        'lokasi_teks', 'lintang', 'bujur', 'tahun_berdiri'
    ];
    
    // Menetapkan tipe data kolom lintang dan bujur sebagai float/decimal
    protected $casts = [
        'lintang' => 'decimal:7',
        'bujur' => 'decimal:7',
    ];

    // Relasi: Situs Budaya Milik Satu Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi: Situs Budaya Memiliki Banyak Foto
    public function foto()
    {
        return $this->hasMany(Gambar::class, 'situs_budaya_id');
    }

    // Relasi: Situs Budaya Memiliki Banyak Riwayat
    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'situs_budaya_id');
    }

    // Relasi: Situs Budaya Memiliki Banyak Ulasan
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'situs_budaya_id');
    }
}