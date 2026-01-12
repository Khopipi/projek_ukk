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
            // Tambahkan kolom untuk menyimpan nama warga jika tidak terdaftar
            $table->string('nama_warga')->nullable()->after('penduduk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kematians', function (Blueprint $table) {
            $table->dropColumn('nama_warga');
        });
    }
};
