<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';

    protected $fillable = ['situs_budaya_id', 'pengguna_id', 'nilai', 'komentar'];

    // Relasi: Ulasan Milik Satu Situs Budaya
    public function situsBudaya()
    {
        return $this->belongsTo(SitusBudaya::class, 'situs_budaya_id');
    }

    // Relasi: Ulasan Dibuat Oleh Satu Pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}