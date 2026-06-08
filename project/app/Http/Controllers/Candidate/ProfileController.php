<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\UpdateCandidateProfileRequest;
use App\Services\Candidate\CandidateProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the candidate profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->loadMissing('candidateProfile');

        return view('candidate.profile.edit', compact('user'));
    }

    /**
     * Update candidate profile details.
     */
    public function update(
        UpdateCandidateProfileRequest $request,
        CandidateProfileService $candidateProfileService
    ): RedirectResponse {
        $candidateProfileService->update($request->user(), $request->validated());

        return redirect()
            ->route('candidate.profile.edit')
            ->with('status', 'Candidate profile updated successfully.');
    }
}
