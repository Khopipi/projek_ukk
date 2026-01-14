<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Convert image file to base64 data URI for PDF embedding
     * This is the most reliable way to include images in DomPDF
     */
    public static function imageToDataUri($imagePath)
    {
        try {
            $fullPath = public_path($imagePath);
            
            // Check if file exists
            if (!file_exists($fullPath)) {
                \Log::warning("Image file not found: " . $fullPath);
                return null;
            }
            
            // Read file content
            $imageContent = file_get_contents($fullPath);
            
            // Get mime type
            $mimeType = mime_content_type($fullPath);
            
            // Create data URI
            $base64 = base64_encode($imageContent);
            return "data:{$mimeType};base64,{$base64}";
        } catch (\Exception $e) {
            \Log::error("Error converting image to data URI: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get image as base64 without data URI prefix (for inline embedding)
     */
    public static function imageToBase64($imagePath)
    {
        try {
            $fullPath = public_path($imagePath);
            
            if (!file_exists($fullPath)) {
                return null;
            }
            
            $imageContent = file_get_contents($fullPath);
            return base64_encode($imageContent);
        } catch (\Exception $e) {
            \Log::error("Error converting image to base64: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get MIME type of image file
     */
    public static function getMimeType($imagePath)
    {
        try {
            $fullPath = public_path($imagePath);
            
            if (!file_exists($fullPath)) {
                return 'image/png'; // default fallback
            }
            
            return mime_content_type($fullPath);
        } catch (\Exception $e) {
            return 'image/png'; // default fallback
        }
    }
}
