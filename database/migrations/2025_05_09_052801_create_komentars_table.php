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
        Schema::create('komentars', function (Blueprint $table) {
            $table->id();

            // Foreign key dokumen_id ke dokumen.id dengan onDelete cascade
            $table->foreignId('dokumen_id')->constrained('dokumen')->onDelete('cascade');

            // Foreign key user_id ke users.id dengan onDelete cascade
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->text('isi'); // Isi komentar

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentars');
    }
};
