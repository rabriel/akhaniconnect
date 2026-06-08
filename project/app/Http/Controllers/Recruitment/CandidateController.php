<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\FilterCandidatesRequest;
use App\Services\Recruitment\CandidateManagementService;
use Illuminate\View\View;

class CandidateController extends Controller
{
    /**
     * Display a searchable recruiter candidate pipeline.
     */
    public function index(
        FilterCandidatesRequest $request,
        CandidateManagementService $candidateManagementService
    ): View {
        $filters = $request->validated();
        $applications = $candidateManagementService->paginate($request->user(), $filters);
        $jobs = $request->user()->jobs()->orderBy('title')->get(['id', 'title']);
        $provinces = config('south_africa.provinces', []);

        return view('recruitment.candidates.index', compact('applications', 'filters', 'jobs', 'provinces'));
    }
}
