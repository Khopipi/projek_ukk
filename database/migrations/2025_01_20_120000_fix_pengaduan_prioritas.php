<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations - Fix existing pengaduan prioritas field
     */
    public function up(): void
    {
        // Set all NULL prioritas to default 'Sedang'
        DB::table('pengaduans')
            ->whereNull('prioritas')
            ->update(['prioritas' => 'Sedang']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be reversed as it modifies existing data
    }
};
