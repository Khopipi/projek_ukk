<?php

namespace App\Mail;

use App\Models\PengajuanSurat;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengajuanHasilMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    /**
     * Create a new message instance.
     */
    public function __construct(PengajuanSurat $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $mail = $this->subject('Surat Hasil Pengajuan - ' . ($this->pengajuan->nomor_pengajuan ?? ''))
            ->view('emails.pengajuan_hasil')
            ->with(['pengajuan' => $this->pengajuan]);

        // Attach PDF if exists
        if ($this->pengajuan->file_surat_hasil) {
            $path = storage_path('app/public/surat_hasil/' . $this->pengajuan->file_surat_hasil);
            if (file_exists($path)) {
                $mail->attach($path, [
                    'as' => $this->pengajuan->file_surat_hasil,
                    'mime' => 'application/pdf'
                ]);
            }
        }

        return $mail;
    }
}
