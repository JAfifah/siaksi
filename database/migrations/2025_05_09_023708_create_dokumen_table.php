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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('deskripsi');
            $table->string('file_path'); // Menambahkan kolom file_path
            $table->foreignId('kriteria_id')->constrained('kriteria'); // sesuaikan jika nama tabel kriteria berbeda
            $table->foreignId('user_id')->constrained('users'); // Menambahkan kolom user_id yang merujuk ke tabel users
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
