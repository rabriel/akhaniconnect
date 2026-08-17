<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StorePopiaAcknowledgementRequest;
use App\Services\Auth\LoginRedirectService;
use App\Services\Privacy\PrivacyAcknowledgementService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PopiaAcknowledgementController extends Controller
{
    /**
     * Show the POPIA acknowledgement step for the current login session.
     */
    public function show(Request $request, PrivacyAcknowledgementService $privacyAcknowledgementService): View|RedirectResponse
    {
        if ($request->session()->get(PrivacyAcknowledgementService::SESSION_KEY) === true) {
            return redirect()->route(app(LoginRedirectService::class)->resolveDashboardRouteName($request->user()));
        }

        return view('auth.popia-acknowledgement', [
            'title' => 'POPIA Acknowledgement | Akhani Connect',
            'heading' => 'POPIA & Personal Information Notice',
            'subheading' => 'Please review and acknowledge the privacy notice before continuing.',
            'privacyNoticeVersion' => $privacyAcknowledgementService->version(),
        ]);
    }

    /**
     * Persist the acknowledgement for this login session and audit trail.
     */
    public function store(
        StorePopiaAcknowledgementRequest $request,
        PrivacyAcknowledgementService $privacyAcknowledgementService,
        LoginRedirectService $loginRedirectService
    ): RedirectResponse {
        $privacyAcknowledgementService->acknowledge($request->user(), $request);

        return redirect()->route($loginRedirectService->resolveDashboardRouteName($request->user()));
    }

    /**
     * Show the full privacy notice.
     */
    public function privacyNotice(PrivacyAcknowledgementService $privacyAcknowledgementService): View
    {
        return view('privacy.notice', [
            'title' => 'POPIA & Privacy Notice | Akhani Connect',
            'heading' => 'POPIA & Personal Information Notice',
            'subheading' => 'How Akhani Connect collects, uses, protects, and retains personal information.',
            'privacyNoticeVersion' => $privacyAcknowledgementService->version(),
        ]);
    }
}
