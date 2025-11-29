<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    
    protected $fillable = ['nama'];

    // Relasi: Satu Kategori memiliki banyak Situs Budaya
    public function situsBudaya()
    {
        return $this->hasMany(SitusBudaya::class, 'kategori_id');
    }
}