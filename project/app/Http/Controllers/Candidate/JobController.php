<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Display published jobs for candidates.
     */
    public function index(): View
    {
        $jobs = Job::query()
            ->with('user.recruitmentProfile')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(10);

        return view('candidate.jobs.index', compact('jobs'));
    }

    /**
     * Display the specified published job.
     */
    public function show(Request $request, Job $job): View
    {
        abort_unless($job->status === 'published', 404);

        $job->load('user.recruitmentProfile');

        $hasApplied = $request->user()->applications()
            ->where('job_id', $job->id)
            ->exists();

        return view('candidate.jobs.show', compact('job', 'hasApplied'));
    }
}
