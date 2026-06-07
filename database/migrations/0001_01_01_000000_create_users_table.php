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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key auto-increment
            $table->string('username');
            $table->string('email')->unique(); // email harus unik
            $table->string('phone');
            $table->text('address');
            $table->string('photo_path')->nullable(); // bisa kosong
            $table->string('password'); // untuk menyimpan password yang sudah di-hash
            $table->rememberToken(); // untuk fitur "ingat saya"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
