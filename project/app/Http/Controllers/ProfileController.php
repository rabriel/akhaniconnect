<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Models\Profile;
use App\Services\Profile\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProfileController extends Controller
{
    /**
     * Show the profile edit screen.
     */
    public function edit(Request $request): View
    {
        $profile = $request->user()->profile()->firstOrCreate(
            ['user_id' => $request->user()->id],
            ['country' => 'ZA']
        );

        $this->authorize('view', $profile);

        return view('account.profile.edit');
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(UpdateProfileRequest $request, ProfileService $profileService): RedirectResponse
    {
        $profile = $request->user()->profile()->firstOrCreate(
            ['user_id' => $request->user()->id],
            ['country' => 'ZA']
        );

        $this->authorize('update', $profile);

        $profileService->update($request->user(), $request->validated());

        return redirect()
            ->route('profile.edit')
            ->with('status', 'Profile updated successfully.');
    }

    /**
     * Display the stored profile picture for an authorized user.
     */
    public function showAvatar(Request $request, Profile $profile): StreamedResponse
    {
        $this->authorize('view', $profile);
        abort_unless($profile->avatar_path, 404);

        return Storage::disk('public')->response($profile->avatar_path);
    }
}
