<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePlatformSettingsRequest;
use App\Services\Admin\AdminSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Show the admin settings form.
     */
    public function edit(AdminSettingService $adminSettingService): View
    {
        $settings = $adminSettingService->getSettings();

        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Update platform settings.
     */
    public function update(
        UpdatePlatformSettingsRequest $request,
        AdminSettingService $adminSettingService
    ): RedirectResponse {
        $adminSettingService->update($request->validated());

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Platform settings updated successfully.');
    }
}
