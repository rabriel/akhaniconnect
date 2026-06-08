<?php

namespace App\Services\Profile;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    /**
     * Update the user's core account details and shared profile.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data): User {
            $user->update([
                'first_name' => $data['first_name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'date_of_birth' => $data['date_of_birth'] ?? null,
                    'gender' => $data['gender'] ?? null,
                    'id_number' => $data['id_number'] ?? null,
                    'passport_number' => $data['passport_number'] ?? null,
                    'phone_secondary' => $data['phone_secondary'] ?? null,
                    'avatar_path' => $this->storeAvatar($user, $data['profile_picture'] ?? null),
                    'address_line_1' => $data['address_line_1'] ?? null,
                    'address_line_2' => $data['address_line_2'] ?? null,
                    'suburb' => $data['suburb'] ?? null,
                    'city' => $data['city'] ?? null,
                    'province' => $data['province'] ?? null,
                    'postal_code' => $data['postal_code'] ?? null,
                    'country' => 'ZA',
                ]
            );

            return $user->fresh(['role', 'profile']);
        });
    }

    /**
     * Persist a new profile picture if one was uploaded.
     */
    protected function storeAvatar(User $user, mixed $uploadedFile): ?string
    {
        if (! $uploadedFile instanceof UploadedFile) {
            return $user->profile?->avatar_path;
        }

        if ($user->profile?->avatar_path) {
            Storage::disk('public')->delete($user->profile->avatar_path);
        }

        return $uploadedFile->store('avatars', 'public');
    }
}
