<?php

namespace App\Helpers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Support\Facades\Log;

class QrCodeGenerator
{
    /**
     * Generate QR Code SVG (NO GD REQUIRED)
     * Returns SVG string directly
     */
    public static function generateSvg(string $data, int $size = 150): string
    {
        try {
            $qrCode = new QrCode(
                data: $data,
                size: $size,
                margin: 10
            );

            $writer = new SvgWriter();
            $result = $writer->write($qrCode);

            return $result->getString();

        } catch (\Throwable $e) {
            Log::error('QR SVG ERROR', [
                'msg' => $e->getMessage(),
                'data' => substr($data, 0, 50)
            ]);
            return '';
        }
    }

    /**
     * Generate SVG as base64 data URI
     * Safe for PDF and email embedding
     */
    public static function generateSvgBase64(string $data, int $size = 150): string
    {
        $svg = self::generateSvg($data, $size);

        if (empty($svg)) {
            Log::warning('SVG generation returned empty', ['data' => substr($data, 0, 50)]);
            return '';
        }

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Generate signature token
     * Format: pengajuan_id|timestamp|user_id|random_hash
     */
    public static function generateSignatureToken(int $pengajuanId, int $userId): string
    {
        return implode('|', [
            $pengajuanId,
            time(),
            $userId,
            substr(md5(uniqid('', true)), 0, 8)
        ]);
    }

    /**
     * Generate QR URL to scan
     * Opens verification page with signature token
     */
    public static function generateQrUrl(string $token): string
    {
        return url('/pengajuan/ttd?p=' . urlencode($token));
    }
}
