<!-- Footer dengan QR Code Digital Signature -->
<div class="footer-content">
    <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
        <div style="text-align: center; width: 220px;">
            <div style="font-size: 11px; margin-bottom: 5px;">LURAH DESA SRUNI,</div>
            
            @if($pengajuan->signature_token && $pengajuan->signature_generated_at)
                <!-- QR Code Digital Signature -->
                <div style="margin: 15px 0; text-align: center;">
                    <img src="{{ App\Helpers\QrCodeGenerator::generateBase64(App\Helpers\QrCodeGenerator::generateQrUrl($pengajuan->signature_token)) }}" 
                         alt="QR Code Tanda Tangan Digital" 
                         style="width: 80px; height: 80px; display: inline-block;">
                </div>
                <div style="font-size: 9px; color: #666; margin-bottom: 10px;">
                    Scan untuk verifikasi tanda tangan digital
                </div>
            @endif
            
            <div style="border-top: 1px solid #000; width: 100%; margin: 15px 0 3px 0;"></div>
            <div style="font-weight: bold; margin-top: 3px; font-size: 11px;">(M.SAIFUL IMADUDDIN, S.KM.,M.KES.)</div>
        </div>
    </div>
</div>
