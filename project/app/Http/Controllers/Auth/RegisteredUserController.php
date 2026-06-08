<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\Auth\LoginRedirectService;
use App\Services\Auth\RegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(
        RegisterUserRequest $request,
        RegistrationService $registrationService,
        LoginRedirectService $loginRedirectService
    ): RedirectResponse {
        $user = $registrationService->register($request->validated());

        Auth::login($user);

        return redirect()->route($loginRedirectService->resolveDashboardRouteName($user));
    }
}
