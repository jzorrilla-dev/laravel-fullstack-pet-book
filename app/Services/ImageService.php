<?php

declare(strict_types=1);

namespace App\Services;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;

final class ImageService
{
    private function getCloudinaryConfig(): Configuration
    {
        return Configuration::instance([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'secure' => true,
        ]);
    }

    public function upload(UploadedFile $file, string $folder, ?string $publicId = null): string
    {
        $options = [
            'folder' => $folder,
        ];

        if ($publicId !== null) {
            $options['public_id'] = $publicId;
        }

        $uploader = new UploadApi($this->getCloudinaryConfig());
        $result = $uploader->upload($file->getRealPath(), $options);

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
            $uploader = new UploadApi($this->getCloudinaryConfig());
            $uploader->destroy($publicId);
        } catch (\Exception $e) {
            logger()->warning('No se pudo eliminar la imagen: '.$e->getMessage());
        }
    }

    private function extractPublicId(string $url): string
    {
        return pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME);
    }
}
