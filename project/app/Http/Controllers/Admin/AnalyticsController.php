<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminAnalyticsService;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    /**
     * Display the user analytics and activity page.
     */
    public function index(AdminAnalyticsService $adminAnalyticsService): View
    {
        $data = $adminAnalyticsService->build();
        $activities = $adminAnalyticsService->paginateActivities();

        return view('admin.analytics.index', array_merge($data, [
            'activities' => $activities,
        ]));
    }
}
