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
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Kolom untuk nama kriteria
            $table->text('tahap'); // Kolom tahapan
            $table->integer('nomor'); // Nomor urut
            $table->boolean('finalisasi_dikirim')->default(false); // Status pengiriman finalisasi
            $table->boolean('finalisasi_disetujui')->default(false); // Status persetujuan direktur
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria');
    }
};
