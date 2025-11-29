<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('situs_budaya_id')->constrained('situs_budaya')->onDelete('cascade');
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->unsignedTinyInteger('nilai'); // Rating 1-5
            $table->text('komentar');
            $table->timestamps();

            // Mencegah satu pengguna memberi ulasan ganda pada situs yang sama
            $table->unique(['situs_budaya_id', 'pengguna_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
