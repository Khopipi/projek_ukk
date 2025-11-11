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
        Schema::create('pengajuan_surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengajuan')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis_surat', [
                'Surat Nikah',
                'Pembuatan KTP',
                'Surat Tanah',
                'Surat Warisan',
                'Surat Domisili',
                'Surat Kelahiran',
                'Surat Keterangan Tidak Mampu'
            ]);
            $table->text('keperluan');
            
            // Data Pemohon
            $table->string('nama_pemohon');
            $table->string('nik_pemohon', 16);
            $table->string('tempat_lahir_pemohon');
            $table->date('tanggal_lahir_pemohon');
            $table->enum('jenis_kelamin_pemohon', ['Laki-laki', 'Perempuan']);
            $table->string('pekerjaan_pemohon');
            $table->text('alamat_pemohon');
            $table->string('no_telepon_pemohon', 15);
            
            // Data Khusus per Jenis Surat (JSON untuk fleksibilitas)
            $table->json('data_tambahan')->nullable();
            
            // Upload Dokumen Pendukung
            $table->string('file_ktp')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_pendukung_1')->nullable();
            $table->string('file_pendukung_2')->nullable();
            $table->string('file_pendukung_3')->nullable();
            
            // Status & Tracking
            $table->enum('status', ['Menunggu', 'Diproses', 'Disetujui', 'Ditolak', 'Selesai'])->default('Menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->timestamp('tanggal_ditolak')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->onDelete('set null');
            
            // File Surat Hasil
            $table->string('file_surat_hasil')->nullable();
            
            $table->timestamps();
            
            // Index untuk performa
            $table->index('user_id');
            $table->index('status');
            $table->index('jenis_surat');
            $table->index('nomor_pengajuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surats');
    }
};