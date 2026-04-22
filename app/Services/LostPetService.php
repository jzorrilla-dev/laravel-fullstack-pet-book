<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\LostPet;
use Illuminate\Http\UploadedFile;

final class LostPetService
{
    public function __construct(
        private readonly ImageService $imageService,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data, int $userId, ?UploadedFile $photo = null): LostPet
    {
        $lostPet = new LostPet;
        $lostPet->user_id = $userId;
        $lostPet->pet_name = $data['pet_name'] ?? null;
        $lostPet->last_seen = $data['last_seen'] ?? null;
        $lostPet->lost_date = $data['lost_date'] ?? null;
        $lostPet->pet_species = $data['pet_species'];
        $lostPet->description = $data['description'] ?? '';

        if ($photo !== null && $photo->isValid()) {
            $lostPet->pet_photo = $this->imageService->upload($photo, 'lost_pets', 'lost_'.time());
        }

        $lostPet->save();

        return $lostPet;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(LostPet $lostPet, array $data, ?UploadedFile $photo = null): LostPet
    {
        $lostPet->pet_name = $data['pet_name'] ?? null;
        $lostPet->last_seen = $data['last_seen'] ?? null;
        $lostPet->lost_date = $data['lost_date'] ?? null;
        $lostPet->pet_species = $data['pet_species'];
        $lostPet->description = $data['description'] ?? '';

        if ($photo !== null && $photo->isValid()) {
            $this->imageService->delete($lostPet->pet_photo);
            $lostPet->pet_photo = $this->imageService->upload($photo, 'lost_pets', 'lost_'.$lostPet->id);
        }

        $lostPet->save();

        return $lostPet;
    }

    public function delete(LostPet $lostPet): void
    {
        $this->imageService->delete($lostPet->pet_photo);
        $lostPet->delete();
    }

    public function isOwner(LostPet $lostPet, int $userId): bool
    {
        return (int) $lostPet->user_id === (int) $userId;
    }
}
