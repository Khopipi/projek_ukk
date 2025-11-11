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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengaduan')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Data Pengaduan
            $table->enum('kategori', [
                'Infrastruktur',
                'Kebersihan',
                'Keamanan',
                'Pelayanan Publik',
                'Kesehatan',
                'Pendidikan',
                'Lainnya'
            ]);
            $table->string('judul');
            $table->text('isi_pengaduan');
            $table->string('lokasi')->nullable();
            
            // Lampiran
            $table->string('foto_1')->nullable();
            $table->string('foto_2')->nullable();
            $table->string('foto_3')->nullable();
            
            // Status & Tanggapan
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->default('Menunggu');
            $table->enum('prioritas', ['Rendah', 'Sedang', 'Tinggi', 'Mendesak'])->default('Sedang');
            
            // Admin Response
            $table->text('tanggapan_admin')->nullable();
            $table->foreignId('ditanggapi_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tanggal_ditanggapi')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('kategori');
            $table->index('nomor_pengaduan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};