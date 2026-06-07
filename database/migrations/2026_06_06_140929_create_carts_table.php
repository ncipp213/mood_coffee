<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // file: database/migrations/...create_carts_table.php
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            // Struktur ini sama persis dengan model CartItem di Flutter
            $table->string('cart_id')->unique(); // id unik untuk item keranjang
            $table->string('name');
            $table->string('image_url');
            $table->string('milk'); // opsi susu
            $table->string('size'); // ukuran minuman
            $table->integer('price');
            $table->integer('quantity')->default(1);
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
