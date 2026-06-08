<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\StoreJobRequest;
use App\Services\Recruitment\JobService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Display a listing of recruiter jobs.
     */
    public function index(Request $request): View
    {
        $jobs = $request->user()->jobs()
            ->latest()
            ->paginate(10);

        return view('recruitment.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a job.
     */
    public function create(): View
    {
        return view('recruitment.jobs.create');
    }

    /**
     * Store a newly created job.
     */
    public function store(StoreJobRequest $request, JobService $jobService): RedirectResponse
    {
        $jobService->create($request->user(), $request->validated());

        return redirect()
            ->route('recruitment.jobs.index')
            ->with('status', 'Job post created successfully.');
    }
}
