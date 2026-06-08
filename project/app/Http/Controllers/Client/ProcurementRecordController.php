<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\FilterProcurementRecordsRequest;
use App\Http\Requests\Client\SendProcurementNotificationRequest;
use App\Models\User;
use App\Services\Client\ClientNotificationService;
use App\Services\Client\ClientProcurementRecordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProcurementRecordController extends Controller
{
    /**
     * Display searchable procurement records for clients.
     */
    public function index(
        FilterProcurementRecordsRequest $request,
        ClientProcurementRecordService $clientProcurementRecordService
    ): View {
        $filters = $request->validated();
        $records = $clientProcurementRecordService->paginate($filters);

        return view('client.procurement-records.index', compact('records', 'filters'));
    }

    /**
     * Display a procurement record detail page for clients.
     */
    public function show(User $procurementUser, ClientProcurementRecordService $clientProcurementRecordService): View
    {
        abort_unless($procurementUser->hasRole('procurement'), 404);

        $record = $clientProcurementRecordService->detail($procurementUser);

        return view('client.procurement-records.show', $record);
    }

    /**
     * Send a client notification to a procurement user.
     */
    public function notify(
        SendProcurementNotificationRequest $request,
        User $procurementUser,
        ClientNotificationService $clientNotificationService
    ): RedirectResponse {
        abort_unless($procurementUser->hasRole('procurement'), 404);

        $clientNotificationService->sendProcurementMessage(
            $request->user(),
            $procurementUser,
            $request->validated()
        );

        return redirect()
            ->route('client.procurement-records.show', $procurementUser)
            ->with('status', 'Notification sent to procurement user successfully.');
    }
}
