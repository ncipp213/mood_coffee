<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // file: database/migrations/...create_coffees_table.php
    public function up(): void
    {
        Schema::create('coffees', function (Blueprint $table) {
            $table->string('id')->primary(); // id dari Flutter, misal '1', '2'
            $table->string('name');
            $table->string('price'); // biarkan string karena contoh data menggunakan "Rp 28.000"
            $table->string('image_url');
            $table->text('description');
            $table->string('category'); // 'hot', 'cold', 'others'
            $table->double('rating', 2, 1)->default(4.5);
            $table->timestamps(); // otomatis membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coffees');
    }
};
