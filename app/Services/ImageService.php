<?php

declare(strict_types=1);

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;

final class ImageService
{
    public function upload(UploadedFile $file, string $folder, ?string $publicId = null): string
    {
        $options = [
            'folder' => $folder,
        ];

        if ($publicId !== null) {
            $options['public_id'] = $publicId;
        }

        $result = Cloudinary::uploadApi()->upload($file->getRealPath(), $options);

        return $result['secure_url'];
    }

    public function delete(?string $url): void
    {
        if ($url === null || $url === '') {
            return;
        }

        if (strpos($url, 'cloudinary') === false) {
            return;
        }

        try {
            $publicId = $this->extractPublicId($url);
            Cloudinary::uploadApi()->destroy($publicId);
        } catch (\Exception $e) {
            logger()->warning('No se pudo eliminar la imagen: '.$e->getMessage());
        }
    }

    private function extractPublicId(string $url): string
    {
        return pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME);
    }
}
