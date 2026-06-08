<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerificationRecord;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * Display all verification records for admin review.
     */
    public function index(): View
    {
        $records = VerificationRecord::query()
            ->with(['user.role', 'attempts'])
            ->latest('updated_at')
            ->paginate(15);

        return view('admin.verifications.index', compact('records'));
    }

    /**
     * Show a single verification record and attempt history.
     */
    public function show(VerificationRecord $verificationRecord): View
    {
        $verificationRecord->load(['user.role', 'user.procurementProfile.directors', 'attempts', 'verifiable']);

        return view('admin.verifications.show', compact('verificationRecord'));
    }
}
