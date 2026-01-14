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
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            // Tambah kolom untuk menyimpan signature token yang digunakan untuk QR code
            $table->string('signature_token')->nullable()->unique();
            $table->timestamp('signature_generated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropColumn(['signature_token', 'signature_generated_at']);
        });
    }
};
