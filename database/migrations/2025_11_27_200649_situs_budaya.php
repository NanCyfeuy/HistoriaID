<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('situs_budaya', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade'); 
            
            // Field Data
            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->string('lokasi_teks');
            $table->decimal('lintang', 10, 7); // Latitude
            $table->decimal('bujur', 10, 7); // Longitude
            $table->year('tahun_berdiri')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('situs_budaya');
    }
};
