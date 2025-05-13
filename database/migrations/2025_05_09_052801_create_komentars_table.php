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
<<<<<<< HEAD
            $table->foreignId('dokumen_id')->constrained('dokumen')->onDelete('cascade');  // Pastikan 'dokumen' sesuai dengan nama tabel yang ada
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('komentar');
            $table->timestamps();
        });
=======
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('table');
            $table->text('isi');
            $table->timestamps();
        });
        
>>>>>>> 2e8eb87c39bff4f296f17a31cb9684ef9f627139
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentars');
    }
};
