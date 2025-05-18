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
        if (Schema::hasTable('kriteria')) {
            Schema::table('kriteria', function (Blueprint $table) {
                $table->text('tahap')->after('id');
                $table->integer('nomor')->after('tahap');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('kriteria')) {
            Schema::table('kriteria', function (Blueprint $table) {
                $table->dropColumn(['tahap', 'nomor']);
            });
        }
    }
};
