<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

final class ProfileService
{
    public function __construct(
        private readonly ImageService $imageService,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(User $user, array $data, ?UploadedFile $photo = null): User
    {
        $user->user_name = $data['user_name'];
        $user->user_phone = $data['user_phone'];
        $user->city = $data['city'];
        $user->email = $data['email'];
        $user->description = $data['description'] ?? $user->description;

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if ($photo !== null && $photo->isValid()) {
            $this->imageService->delete($user->photo);

            $user->photo = $this->imageService->upload($photo, 'profile_photos', 'profile_'.$user->user_id);
        }

        $user->save();

        return $user;
    }

    public function destroy(User $user, string $password): bool
    {
        if (! Hash::check($password, $user->password)) {
            return false;
        }

        $this->imageService->delete($user->photo);

        $user->delete();

        return true;
    }
}
