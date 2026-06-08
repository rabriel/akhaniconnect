<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\UpdateCompanyProfileRequest;
use App\Services\Recruitment\RecruitmentCompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the recruiter company profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->loadMissing('recruitmentProfile');

        return view('recruitment.profile.edit', compact('user'));
    }

    /**
     * Update recruiter company profile details.
     */
    public function update(
        UpdateCompanyProfileRequest $request,
        RecruitmentCompanyService $recruitmentCompanyService
    ): RedirectResponse {
        $recruitmentCompanyService->update($request->user(), $request->validated());

        return redirect()
            ->route('recruitment.profile.edit')
            ->with('status', 'Recruitment company profile updated successfully.');
    }
}
