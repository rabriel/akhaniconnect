<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\StoreJobRequest;
use App\Models\Job;
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
        return view('recruitment.jobs.create', [
            'job' => new Job(),
        ]);
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(Request $request, Job $job): View
    {
        $job = $request->user()->jobs()->findOrFail($job->getKey());

        return view('recruitment.jobs.edit', compact('job'));
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

    /**
     * Update the specified recruiter job.
     */
    public function update(StoreJobRequest $request, Job $job, JobService $jobService): RedirectResponse
    {
        $job = $request->user()->jobs()->findOrFail($job->getKey());

        $jobService->update($job, $request->validated());

        return redirect()
            ->route('recruitment.jobs.index')
            ->with('status', 'Job post updated successfully.');
    }

    /**
     * Remove the specified recruiter job.
     */
    public function destroy(Request $request, Job $job, JobService $jobService): RedirectResponse
    {
        $job = $request->user()->jobs()->findOrFail($job->getKey());

        $jobService->delete($job);

        return redirect()
            ->route('recruitment.jobs.index')
            ->with('status', 'Job post deleted successfully.');
    }
}
