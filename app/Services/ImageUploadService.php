<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ImageUploadService
{
    public const MAX_SIZE_BYTES = 5 * 1024 * 1024; // 5 MB

    /**
     * Store an uploaded image in public storage, automatically compressing it
     * to stay at or below $maxBytes when the original upload exceeds the limit.
     */
    public function storeCompressedImage(
        UploadedFile $file,
        string $prefix = 'img',
        int $maxBytes = self::MAX_SIZE_BYTES,
        string $attribute = 'image_file'
    ): string {
        $baseName = $prefix.'_'.time().'_'.Str::random(5);

        if ($file->getSize() !== false && $file->getSize() <= $maxBytes) {
            $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
            $fileName = "{$baseName}.{$extension}";
            $file->storeAs('images', $fileName, 'public');

            return 'storage/images/'.$fileName;
        }

        if (! extension_loaded('gd')) {
            throw ValidationException::withMessages([
                $attribute => 'Ukuran gambar melebihi 5MB dan modul kompresi server (GD) belum aktif.',
            ]);
        }

        $raw = @file_get_contents($file->getRealPath());
        $source = $raw !== false ? @imagecreatefromstring($raw) : false;

        if ($source === false) {
            throw ValidationException::withMessages([
                $attribute => 'File gambar tidak dapat dibaca untuk dikompresi.',
            ]);
        }

        $source = $this->applyExifOrientation($source, $file->getRealPath());
        $mime = strtolower((string) ($file->getMimeType() ?: 'image/jpeg'));

        [$encoded, $extension] = $this->compressToTargetSize($source, $mime, $maxBytes);
        unset($source);

        if ($encoded === null || strlen($encoded) > $maxBytes) {
            throw ValidationException::withMessages([
                $attribute => 'Gambar gagal dikompresi di bawah batas maksimal 5MB. Gunakan resolusi yang lebih kecil.',
            ]);
        }

        $fileName = "{$baseName}.{$extension}";
        Storage::disk('public')->put('images/'.$fileName, $encoded);

        return 'storage/images/'.$fileName;
    }

    /**
     * Iteratively encode and, if necessary, downscale the GD image until <= $maxBytes.
     *
     * @return array{0: string|null, 1: string}
     */
    private function compressToTargetSize(\GdImage $source, string $mime, int $maxBytes): array
    {
        $useWebp = $mime !== 'image/jpeg' && function_exists('imagewebp');
        $extension = $useWebp ? 'webp' : 'jpg';
        $origWidth = max(1, imagesx($source));
        $origHeight = max(1, imagesy($source));

        $scales = [1.0, 0.85, 0.7, 0.56, 0.44, 0.34, 0.25];
        $bestBinary = null;

        foreach ($scales as $scale) {
            $targetWidth = max(1, (int) round($origWidth * $scale));
            $targetHeight = max(1, (int) round($origHeight * $scale));

            if ($scale < 1.0 && max($targetWidth, $targetHeight) < 320 && max($origWidth, $origHeight) >= 320) {
                continue;
            }

            $canvas = $this->resizeCanvas($source, $origWidth, $origHeight, $targetWidth, $targetHeight, ! $useWebp);
            $qualities = $scale === 1.0 ? [90, 82, 74, 65, 55, 45, 35] : [80, 68, 56, 44, 34];

            foreach ($qualities as $quality) {
                $binary = $this->encodeCanvas($canvas, $useWebp, $quality);
                if ($binary === null) {
                    continue;
                }

                if ($bestBinary === null || strlen($binary) < strlen($bestBinary)) {
                    $bestBinary = $binary;
                }

                if (strlen($binary) <= $maxBytes) {
                    unset($canvas);

                    return [$binary, $extension];
                }
            }

            unset($canvas);
        }

        return [$bestBinary, $extension];
    }

    private function resizeCanvas(
        \GdImage $source,
        int $origWidth,
        int $origHeight,
        int $targetWidth,
        int $targetHeight,
        bool $flattenAlpha
    ): \GdImage {
        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);

        if ($flattenAlpha) {
            $white = imagecolorallocate($canvas, 255, 255, 255);
            imagefill($canvas, 0, 0, $white);
        } else {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefill($canvas, 0, 0, $transparent);
        }

        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $origWidth, $origHeight);

        return $canvas;
    }

    private function encodeCanvas(\GdImage $canvas, bool $useWebp, int $quality): ?string
    {
        ob_start();
        $ok = $useWebp
            ? imagewebp($canvas, null, $quality)
            : imagejpeg($canvas, null, $quality);
        $data = ob_get_clean();

        if (! $ok || $data === false || $data === '') {
            return null;
        }

        return $data;
    }

    private function applyExifOrientation(\GdImage $image, string $path): \GdImage
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($path);
        $orientation = (int) ($exif['Orientation'] ?? 1);

        $rotated = match ($orientation) {
            3 => imagerotate($image, 180, 0),
            6 => imagerotate($image, -90, 0),
            8 => imagerotate($image, 90, 0),
            default => null,
        };

        return $rotated instanceof \GdImage ? $rotated : $image;
    }
}
