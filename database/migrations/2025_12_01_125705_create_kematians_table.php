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
        Schema::create('kematians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduks')->onDelete('cascade');
            $table->date('tanggal_kematian');
            $table->string('penyebab_kematian')->nullable();
            $table->string('tempat_kematian')->nullable();
            $table->string('rs_atau_rumah')->nullable(); // RS atau Rumah
            $table->string('usia_saat_meninggal')->nullable();
            $table->string('nama_diperiksa_oleh')->nullable(); // Dokter/Petugas
            $table->text('keterangan')->nullable();
            $table->string('input_oleh')->nullable(); // User yang input
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kematians');
    }
};
