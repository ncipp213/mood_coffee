<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // file: database/migrations/...create_favorites_table.php
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->string('coffee_id'); // id kopi yang difavoritkan
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Relasi ke tabel coffees
            $table->foreign('coffee_id')->references('id')->on('coffees')->onDelete('cascade');
            $table->timestamps();
            
            // Satu user hanya bisa memfavoritkan satu kopi satu kali
            $table->unique(['user_id', 'coffee_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
