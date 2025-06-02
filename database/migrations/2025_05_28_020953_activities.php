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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            // Foreign key user_id ke users.id dengan onDelete cascade
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Foreign key komentar_id ke komentars.id dengan onDelete cascade
            $table->foreignId('komentar_id')->constrained('komentars')->onDelete('cascade');

            $table->string('type')->default('comment'); // Tipe aktivitas
            $table->text('description'); // Deskripsi aktivitas (isi komentar)
            $table->string('action')->default('created'); // created, updated, deleted
            $table->boolean('is_read')->default(false); // Penanda apakah sudah dibaca

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
