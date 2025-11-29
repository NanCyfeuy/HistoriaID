<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gambar extends Model
{
    use HasFactory;

    protected $table = 'gambar';

    protected $fillable = ['situs_budaya_id', 'path_url', 'keterangan'];

    // Relasi: Foto Milik Satu Situs Budaya
    public function situsBudaya()
    {
        return $this->belongsTo(SitusBudaya::class, 'situs_budaya_id');
    }
}