<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class ImageService
{
    /**
     * Process an uploaded file, fix EXIF orientation, convert to WebP, and store it.
     *
     * @param UploadedFile $file The uploaded image file
     * @param string $directory The public storage directory (e.g., 'photo-user')
     * @param int $quality The WebP quality (0-100)
     * @return string The generated filename
     */
    public function processAndStore(UploadedFile $file, string $directory, int $quality = 82): string
    {
        $sourcePath = $file->getRealPath();
        
        $info = @getimagesize($sourcePath);

        if (!$info) {
            throw new RuntimeException('File gambar tidak valid.');
        }

        $mime = $info['mime'];

        $image = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($sourcePath),
            'image/png'  => (function () use ($sourcePath) {
                $img = imagecreatefrompng($sourcePath);
                // Pertahankan transparansi PNG
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
                return $img;
            })(),
            'image/webp' => imagecreatefromwebp($sourcePath),
            'image/gif'  => imagecreatefromgif($sourcePath),
            default      => throw new RuntimeException('Format gambar tidak didukung: ' . $mime),
        };

        if (!$image) {
            throw new RuntimeException('Gagal memproses gambar.');
        }

        // ── Fix EXIF orientation (foto miring dari kamera HP/Android/iPhone) ──
        if ($mime === 'image/jpeg' && function_exists('exif_read_data')) {
            $exif = @exif_read_data($sourcePath);
            $orientation = isset($exif['Orientation']) ? (int) $exif['Orientation'] : 1;

            if (in_array($orientation, [3, 6, 8], true)) {
                $degrees = match ($orientation) {
                    3 => 180,
                    6 => -90,
                    8 =>  90,
                };
                $rotated = imagerotate($image, $degrees, 0);
                imagedestroy($image);
                $image = $rotated;
            }
        }

        // Generate WebP
        ob_start();
        imagewebp($image, null, $quality);
        $webpData = ob_get_clean();
        imagedestroy($image);

        if (!$webpData) {
            throw new RuntimeException('Gagal mengonversi gambar ke WebP.');
        }

        $filename = Str::uuid()->toString() . '.webp';
        $path = rtrim($directory, '/') . '/' . $filename;

        $stored = Storage::disk('public')->put($path, $webpData);

        if ($stored === false) {
            throw new RuntimeException('Gagal menyimpan file WebP ke storage.');
        }

        return $filename;
    }

    /**
     * Allowed raster image MIME types for base64 upload validation.
     * SVG, HTML, and other non-raster types are explicitly excluded.
     */
    private const ALLOWED_BASE64_MIMES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    /**
     * Store a base64 encoded image directly (e.g., from Cropper.js).
     * Validates with server-side magic bytes detection, rejects non-image payloads,
     * and re-encodes through GD to neutralize any embedded scripts.
     *
     * @param string $base64 The base64 data string
     * @param string $directory The public storage directory
     * @param int $quality The WebP quality (0-100)
     * @return string The generated filename
     */
    public function storeBase64(string $base64, string $directory, int $quality = 82): string
    {
        $base64Data = preg_replace('/^data:[^;]+;base64,/', '', $base64);
        $imageData  = base64_decode($base64Data, true);

        if ($imageData === false || strlen($imageData) < 100) {
            throw new RuntimeException('Data gambar base64 tidak valid.');
        }

        // Server-side validation: check actual magic bytes, not client MIME claim
        $info = @getimagesizefromstring($imageData);
        if ($info === false) {
            throw new RuntimeException('Data bukan gambar yang valid (magic bytes gagal).');
        }

        $detectedMime = $info['mime'] ?? '';
        if (!in_array($detectedMime, self::ALLOWED_BASE64_MIMES, true)) {
            throw new RuntimeException('Format gambar tidak diizinkan: ' . $detectedMime);
        }

        // Re-encode through GD to strip any embedded payloads (EXIF, trailing data, polyglots)
        $image = @imagecreatefromstring($imageData);
        if (!$image) {
            throw new RuntimeException('Gagal memproses gambar base64 melalui GD.');
        }

        // Preserve transparency for PNG sources
        if ($detectedMime === 'image/png') {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        ob_start();
        imagewebp($image, null, $quality);
        $webpData = ob_get_clean();
        imagedestroy($image);

        if (!$webpData) {
            throw new RuntimeException('Gagal mengonversi gambar base64 ke WebP.');
        }

        $filename = Str::uuid()->toString() . '.webp';
        $path = rtrim($directory, '/') . '/' . $filename;

        Storage::disk('public')->put($path, $webpData);

        return $filename;
    }

    /**
     * Process a base64 data URI from an inline <img> tag (e.g., WYSIWYG editor).
     * Validates the data URI, decodes, checks magic bytes, re-encodes through GD,
     * and stores as WebP.
     *
     * @param string $dataUri The full data:image/...;base64,... string
     * @param string $directory The public storage directory
     * @return string|null The stored filename, or null if the data URI is not a valid image
     */
    public function processBase64InlineImage(string $dataUri, string $directory): ?string
    {
        // Only process data:image URIs
        if (strpos($dataUri, 'data:image') !== 0) {
            return null;
        }

        try {
            return $this->storeBase64($dataUri, $directory);
        } catch (RuntimeException) {
            // Invalid/malicious payload — silently reject (image will be removed from HTML)
            return null;
        }
    }
}
