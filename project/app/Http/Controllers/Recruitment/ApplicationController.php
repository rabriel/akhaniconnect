<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\SendCandidateNotificationRequest;
use App\Http\Requests\Recruitment\UpdateApplicationStatusRequest;
use App\Models\Application;
use App\Services\Recruitment\CandidateManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    /**
     * Display applications submitted to the recruiter's jobs.
     */
    public function index(Request $request): View
    {
        $applications = Application::query()
            ->with(['job', 'candidate.candidateProfile'])
            ->withCount('documents')
            ->whereHas('job', fn ($query) => $query->where('user_id', $request->user()->id))
            ->latest()
            ->paginate(10);

        return view('recruitment.applications.index', compact('applications'));
    }

    /**
     * Display a single application review page.
     */
    public function show(
        Request $request,
        Application $application,
        CandidateManagementService $candidateManagementService
    ): View {
        $application = $candidateManagementService->findManagedApplication($request->user(), $application);

        return view('recruitment.applications.show', compact('application'));
    }

    /**
     * Update the recruiter review status for an application.
     */
    public function update(
        UpdateApplicationStatusRequest $request,
        Application $application,
        CandidateManagementService $candidateManagementService
    ): RedirectResponse {
        $application = $candidateManagementService->findManagedApplication($request->user(), $application);
        $candidateManagementService->updateApplication($application, $request->validated());

        return redirect()
            ->route('recruitment.applications.show', $application)
            ->with('status', 'Application review updated successfully.');
    }

    /**
     * Send a recruiter message to the candidate.
     */
    public function notify(
        SendCandidateNotificationRequest $request,
        Application $application,
        CandidateManagementService $candidateManagementService
    ): RedirectResponse {
        $application = $candidateManagementService->findManagedApplication($request->user(), $application);
        $candidateManagementService->notifyCandidate($request->user(), $application, $request->validated());

        return redirect()
            ->route('recruitment.applications.show', $application)
            ->with('status', 'Candidate notification sent successfully.');
    }
}
