<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\AdminUserInsightService;
use Illuminate\View\View;

class UserDetailController extends Controller
{
    /**
     * Display a role-specific user detail page for superadmin review.
     */
    public function show(User $user, AdminUserInsightService $adminUserInsightService): View
    {
        $this->authorize('view', $user);

        if ($user->hasRole('procurement')) {
            return view('admin.users.show-procurement', $adminUserInsightService->procurementDetail($user));
        }

        if ($user->hasRole('candidate')) {
            return view('admin.users.show-candidate', $adminUserInsightService->candidateDetail($user));
        }

        return view('admin.users.show', compact('user'));
    }
}
