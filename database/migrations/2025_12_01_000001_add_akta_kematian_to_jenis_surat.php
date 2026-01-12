<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Changing the column to VARCHAR to avoid ENUM truncation issues when
        // inserting new/unknown values (safer and more flexible).
        // Note: this keeps existing values intact.
        DB::statement("ALTER TABLE `pengajuan_surats` MODIFY `jenis_surat` VARCHAR(191) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to ENUM with the known set of values. This may fail if the
        // table contains values not present in the ENUM list. If that happens,
        // clean/normalize data before rolling back.
        DB::statement("ALTER TABLE `pengajuan_surats` MODIFY `jenis_surat` ENUM('Surat Nikah','Pembuatan KTP','Surat Tanah','Surat Warisan','Surat Domisili','Surat Akta Kelahiran','Surat Keterangan Tidak Mampu','Surat Akta Kematian') NOT NULL");
    }
};
