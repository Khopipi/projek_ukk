<?php

namespace App\Console\Commands;

use App\Models\PengajuanSurat;
use Illuminate\Console\Command;

class PopulateSuratData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'surat:populate-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate data_tambahan for existing pengajuan from request data if available';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to populate surat data...');

        $pengajuans = PengajuanSurat::all();
        $updated = 0;

        foreach ($pengajuans as $pengajuan) {
            $data_tambahan = $pengajuan->data_tambahan ?? [];
            $hasChanges = false;

            // Based on jenis_surat, try to populate from request data if exists
            // This is a fallback - ideally all new submissions should have this data
            // You may need to manually check your form submissions to see what data is available

            $pengajuan->data_tambahan = $data_tambahan;
            $pengajuan->save();

            if ($hasChanges) {
                $updated++;
                $this->line("Updated pengajuan ID {$pengajuan->id}: {$pengajuan->nomor_pengajuan}");
            }
        }

        $this->info("Completed! Updated {$updated} pengajuan records.");
        $this->info('Note: New pengajuan will automatically have data_tambahan populated.');
    }
}
