<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Pet;
use Illuminate\Http\UploadedFile;

final class PetService
{
    public function __construct(
        private readonly ImageService $imageService,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     * @param  int|string|null  $userId
     */
    public function create(array $data, int|string|null $userId, ?UploadedFile $photo = null): Pet
    {
        $pet = new Pet;
        $pet->pet_name = $data['pet_name'];
        $pet->location = $data['location'];
        $pet->description = $data['description'] ?? '';
        $pet->pet_species = $data['pet_species'];
        $pet->health_condition = $data['health_condition'] ?? '';
        $pet->castrated = $data['castrated'];
        $pet->pet_status = 'available';
        $pet->user_id = $userId !== null ? (int) $userId : null;

        if ($photo !== null && $photo->isValid()) {
            $pet->pet_photo = $this->imageService->upload($photo, 'pets', 'pet_'.time());
        }

        $pet->save();

        return $pet;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  int|string|null  $userId
     */
    public function update(Pet $pet, array $data, int|string|null $userId, ?UploadedFile $photo = null): Pet
    {
        $pet->pet_name = $data['pet_name'];
        $pet->location = $data['location'];
        $pet->description = $data['description'] ?? '';
        $pet->pet_species = $data['pet_species'];
        $pet->health_condition = $data['health_condition'] ?? '';
        $pet->castrated = $data['castrated'];

        if ($photo !== null && $photo->isValid()) {
            $this->imageService->delete($pet->pet_photo);
            $pet->pet_photo = $this->imageService->upload($photo, 'pets', 'pet_'.$pet->pet_id);
        }

        $pet->save();

        return $pet;
    }

    public function delete(Pet $pet): void
    {
        $this->imageService->delete($pet->pet_photo);
        $pet->delete();
    }

    public function isOwner(Pet $pet, int|string|null $userId): bool
    {
        return (int) $pet->user_id === (int) $userId;
    }
}
