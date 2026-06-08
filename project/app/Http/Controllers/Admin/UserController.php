<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\Admin\AdminUserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users for superadmin management.
     */
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $users = User::query()
            ->with('role')
            ->orderBy('first_name')
            ->orderBy('surname')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        $this->authorize('create', User::class);

        $roles = Role::query()
            ->whereIn('slug', ['candidate', 'recruitment', 'procurement', 'client'])
            ->orderBy('name')
            ->get();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        $roles = Role::query()
            ->whereIn('slug', ['candidate', 'recruitment', 'procurement', 'client'])
            ->orderBy('name')
            ->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(StoreUserRequest $request, AdminUserService $adminUserService): RedirectResponse
    {
        $this->authorize('create', User::class);

        $adminUserService->create($request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User account created successfully.');
    }

    /**
     * Update the specified user.
     */
    public function update(
        UpdateUserRequest $request,
        User $user,
        AdminUserService $adminUserService
    ): RedirectResponse {
        $this->authorize('update', $user);

        $adminUserService->update($user, $request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User account updated successfully.');
    }
}
