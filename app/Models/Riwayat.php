<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;

    protected $table = 'riwayat';

    protected $fillable = ['situs_budaya_id', 'judul', 'era', 'detail'];

    // Relasi: Riwayat Milik Satu Situs Budaya
    public function situsBudaya()
    {
        return $this->belongsTo(SitusBudaya::class, 'situs_budaya_id');
    }
}