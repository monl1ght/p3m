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
     * Store a base64 encoded image directly (e.g., from Cropper.js).
     * Assumes the frontend already handled cropping and compression to WebP.
     *
     * @param string $base64 The base64 data string
     * @param string $directory The public storage directory
     * @return string The generated filename
     */
    public function storeBase64(string $base64, string $directory): string
    {
        $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $base64);
        $imageData  = base64_decode($base64Data);

        if ($imageData === false || strlen($imageData) < 100) {
            throw new RuntimeException('Data gambar base64 tidak valid.');
        }

        $filename = Str::uuid()->toString() . '.webp';
        $path = rtrim($directory, '/') . '/' . $filename;

        Storage::disk('public')->put($path, $imageData);

        return $filename;
    }
}
