<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubmissionUploadCacheService
{
    /**
     * Capture newly uploaded valid files into private temporary storage or preserve existing valid cached uploads.
     *
     * @param Request $request
     * @param int $userId
     * @return array{
     *     cached_uppdf: ?string,
     *     cached_uppdf_name: ?string,
     *     cached_foto: ?string,
     *     cached_foto_name: ?string,
     *     has_pdf: bool,
     *     has_photo: bool
     * }
     */
    public function captureCachedUploads(Request $request, int $userId): array
    {
        $cachedUppdf = null;
        $cachedUppdfName = null;
        $cachedFoto = null;
        $cachedFotoName = null;

        // ── 1. Process PDF (uppdf) ──
        if ($request->hasFile('uppdf') && $request->file('uppdf')->isValid()) {
            $pdf = $request->file('uppdf');
            // SEC-FILE-01: Use server-detected extension instead of client-supplied
            $ext = strtolower($pdf->guessExtension() ?: 'bin');
            $mime = strtolower($pdf->getMimeType() ?: '');

            // Ensure valid PDF up to 20 MB (20480 KB)
            if (($ext === 'pdf' || str_contains($mime, 'pdf')) && $pdf->getSize() <= 20480 * 1024) {
                $tempName = 'temp_pdf_' . $userId . '_' . Str::random(24) . '.pdf';
                $path = 'temp_uploads/' . $userId . '/' . $tempName;
                Storage::disk('private')->putFileAs('temp_uploads/' . $userId, $pdf, $tempName);

                // Delete previous cached PDF if different
                $prevPdf = (string) $request->input('cached_uppdf');
                if ($prevPdf && $prevPdf !== $path) {
                    $this->deleteTempFile($prevPdf);
                }

                $cachedUppdf = $path;
                $cachedUppdfName = $pdf->getClientOriginalName();
            }
        } elseif ($request->filled('cached_uppdf')) {
            $path = (string) $request->input('cached_uppdf');
            if ($this->isValidUserTempPath($path, $userId, 'pdf')) {
                $cachedUppdf = $path;
                $cachedUppdfName = (string) $request->input('cached_uppdf_name', 'laporan.pdf');
            }
        }

        // ── 2. Process Foto (foto) ──
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $foto = $request->file('foto');
            // SEC-FILE-01: Use server-detected extension instead of client-supplied
            $ext = strtolower($foto->guessExtension() ?: 'bin');
            $mime = strtolower($foto->getMimeType() ?: '');
            $allowedExts = ['jpg', 'jpeg', 'png'];
            $allowedMimes = ['image/jpeg', 'image/png'];

            // Ensure valid image up to 2 MB (2048 KB)
            if (in_array($ext, $allowedExts, true) &&
                (in_array($mime, $allowedMimes, true) || $mime === 'application/octet-stream' || empty($mime)) &&
                $foto->getSize() <= 2048 * 1024) {

                $safeExt = ($ext === 'jpeg' ? 'jpg' : $ext);
                $tempName = 'temp_foto_' . $userId . '_' . Str::random(24) . '.' . $safeExt;
                $path = 'temp_uploads/' . $userId . '/' . $tempName;
                Storage::disk('private')->putFileAs('temp_uploads/' . $userId, $foto, $tempName);

                // Delete previous cached photo if different
                $prevFoto = (string) $request->input('cached_foto');
                if ($prevFoto && $prevFoto !== $path) {
                    $this->deleteTempFile($prevFoto);
                }

                $cachedFoto = $path;
                $cachedFotoName = $foto->getClientOriginalName();
            }
        } elseif ($request->filled('cached_foto')) {
            $path = (string) $request->input('cached_foto');
            if ($this->isValidUserTempPath($path, $userId, ['jpg', 'jpeg', 'png'])) {
                $cachedFoto = $path;
                $cachedFotoName = (string) $request->input('cached_foto_name', 'foto.jpg');
            }
        }

        return [
            'cached_uppdf' => $cachedUppdf,
            'cached_uppdf_name' => $cachedUppdfName,
            'cached_foto' => $cachedFoto,
            'cached_foto_name' => $cachedFotoName,
            'has_pdf' => !empty($cachedUppdf) || $request->hasFile('uppdf'),
            'has_photo' => !empty($cachedFoto) || $request->hasFile('foto'),
        ];
    }

    /**
     * Resolve final PDF filename from either new upload or cached temporary file.
     */
    public function resolveFinalPdf(Request $request, ?string $cachedPath, callable $storePdfCallback): string
    {
        if ($request->hasFile('uppdf') && $request->file('uppdf')->isValid()) {
            $filename = $storePdfCallback($request->file('uppdf'));
            $this->deleteTempFile($cachedPath);

            return $filename;
        }

        if ($cachedPath && Storage::disk('private')->exists($cachedPath)) {
            $uuid = Str::uuid()->toString() . '.pdf';
            $finalPath = 'submissions/' . $uuid;
            Storage::disk('private')->move($cachedPath, $finalPath);

            return $uuid;
        }

        throw new \RuntimeException('File PDF laporan tidak ditemukan.');
    }

    /**
     * Resolve final Photo filename from either new upload or cached temporary file.
     */
    public function resolveFinalPhoto(Request $request, ?string $cachedPath, callable $storePhotoCallback): string
    {
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $filename = $storePhotoCallback($request->file('foto'));
            $this->deleteTempFile($cachedPath);

            return $filename;
        }

        if ($cachedPath && Storage::disk('private')->exists($cachedPath)) {
            $fullPath = Storage::disk('private')->path($cachedPath);
            $mime = @mime_content_type($fullPath) ?: 'image/jpeg';
            $originalName = basename($cachedPath);
            $uploadedFile = new UploadedFile($fullPath, $originalName, $mime, null, true);
            $filename = $storePhotoCallback($uploadedFile);
            $this->deleteTempFile($cachedPath);

            return $filename;
        }

        throw new \RuntimeException('File foto kegiatan tidak ditemukan.');
    }

    /**
     * Delete temporary file if exists.
     */
    public function deleteTempFile(?string $path): void
    {
        if ($path && Storage::disk('private')->exists($path)) {
            Storage::disk('private')->delete($path);
        }
    }

    /**
     * Clean all temporary uploads for user.
     */
    public function cleanUserTempFiles(int $userId): void
    {
        $dir = 'temp_uploads/' . $userId;
        if (Storage::disk('private')->exists($dir)) {
            Storage::disk('private')->deleteDirectory($dir);
        }
    }

    /**
     * Validate that path belongs to the given user and has an allowed extension.
     */
    private function isValidUserTempPath(string $path, int $userId, string|array $extensions): bool
    {
        $prefix = 'temp_uploads/' . $userId . '/';
        if (!Str::startsWith($path, $prefix)) {
            return false;
        }

        if (!Storage::disk('private')->exists($path)) {
            return false;
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $allowed = (array) $extensions;

        return in_array($ext, $allowed, true);
    }
}
