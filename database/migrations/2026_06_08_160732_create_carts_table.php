<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->string('milk');          // jenis susu
            $table->string('size');          // ukuran (small, medium, large)
            $table->decimal('unit_price', 10, 2); // harga satuan
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // biar tidak duplikat item yang sama persis (menu, milk, size)
            $table->unique(['user_id', 'menu_id', 'milk', 'size']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};