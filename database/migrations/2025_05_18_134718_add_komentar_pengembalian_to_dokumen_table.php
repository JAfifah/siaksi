<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('dokumen', function (Blueprint $table) {
        $table->text('komentar_pengembalian')->nullable()->after('status');
    });
}

public function down()
{
    Schema::table('dokumen', function (Blueprint $table) {
        $table->dropColumn('komentar_pengembalian');
    });
}
};
