<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\StoreApplicationRequest;
use App\Models\Job;
use App\Services\Candidate\CandidateApplicationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the candidate's applications.
     */
    public function index(Request $request): View
    {
        $applications = $request->user()->applications()
            ->with('job.user.recruitmentProfile')
            ->withCount('documents')
            ->latest()
            ->paginate(10);

        return view('candidate.applications.index', compact('applications'));
    }

    /**
     * Store a newly created application.
     */
    public function store(
        StoreApplicationRequest $request,
        Job $job,
        CandidateApplicationService $candidateApplicationService
    ): RedirectResponse {
        $candidateApplicationService->apply($request->user(), $job, $request->validated());

        return redirect()
            ->route('candidate.applications.index')
            ->with('status', 'Application submitted successfully.');
    }
}
