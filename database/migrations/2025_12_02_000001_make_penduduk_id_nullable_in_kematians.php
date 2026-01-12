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
        Schema::table('kematians', function (Blueprint $table) {
            // Ubah penduduk_id menjadi nullable dan hapus foreign key constraint
            $table->dropForeign('kematians_penduduk_id_foreign');
            $table->foreignId('penduduk_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kematians', function (Blueprint $table) {
            $table->dropForeign('kematians_penduduk_id_foreign');
            $table->foreignId('penduduk_id')->constrained('penduduks')->onDelete('cascade')->change();
        });
    }
};
