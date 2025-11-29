<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel di database
    protected $table = 'pengguna';
    
    // Field yang boleh diisi (mass assignable)
    protected $fillable = [
        'nama',
        'email',
        'kata_sandi',
        'peran', // Tambahkan peran (admin/pengguna)
    ];
    
    // Hidden fields (tidak ditampilkan saat diubah ke array/JSON)
    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    // PENTING: beri tahu Laravel bahwa kolom password = kata_sandi
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    // Relasi: Satu Pengguna bisa membuat banyak Ulasan
    public function ulasan()
    {
        // Secara eksplisit tentukan foreign key-nya
        return $this->hasMany(Ulasan::class, 'pengguna_id'); 
    }
}