<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Models\User;
use App\Services\Admin\ClientManagementService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of client accounts.
     */
    public function index(): View
    {
        abort_unless(auth()->user()?->hasPermissionTo('clients.manage'), 403);

        $clients = User::query()
            ->with('clientProfile')
            ->whereHas('role', fn ($query) => $query->where('slug', 'client'))
            ->orderBy('first_name')
            ->orderBy('surname')
            ->paginate(10);

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the client creation form.
     */
    public function create(): View
    {
        abort_unless(auth()->user()?->hasPermissionTo('clients.manage'), 403);

        return view('admin.clients.create');
    }

    /**
     * Store a new client account.
     */
    public function store(StoreClientRequest $request, ClientManagementService $clientManagementService): RedirectResponse
    {
        $clientManagementService->create($request->validated());

        return redirect()
            ->route('admin.clients.index')
            ->with('status', 'Client account created successfully.');
    }
}
