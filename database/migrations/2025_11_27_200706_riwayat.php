<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('situs_budaya_id')->constrained('situs_budaya')->onDelete('cascade');
            $table->string('judul');
            $table->string('era'); // Misalnya: "Era Kolonial", "Abad Ke-15"
            $table->text('detail');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};