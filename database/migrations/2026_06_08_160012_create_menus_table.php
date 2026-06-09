<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Nama menu (Cappuccino, dll)
            $table->string('slug')->unique();    // URL-friendly name
            $table->text('description');         // Deskripsi singkat
            $table->decimal('price', 10, 2);     // Harga (Rp 28.000, dll)
            $table->decimal('rating', 2, 1);     // Rating (4.8, 4.6, dll)
            $table->string('image_url')->nullable(); // URL gambar menu
            $table->string('category');          // Kategori (Menu Kopi, Dessert, dll)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
