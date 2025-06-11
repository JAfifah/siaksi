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
            $table->text('isi')->nullable(); // isi dokumen opsional
            $table->string('file_path')->nullable(); // path file opsional
            $table->foreignId('kriteria_id')->constrained('kriteria'); // FK ke tabel kriteria (pastikan tabel kriteria)
            $table->string('tahap'); // kolom tahap, wajib diisi
            $table->foreignId('user_id')->constrained('users'); // FK ke user pembuat
            $table->string('status')->nullable(); // status dokumen, bisa 'draft', 'dikirim', dll.
            $table->string('link')->nullable(); // tambahkan kolom link jika kamu pakai
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
