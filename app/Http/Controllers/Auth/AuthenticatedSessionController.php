<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        // আগের return view('auth.login'); মুছে নিচের কোডটুকু দিন:
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Role-based redirect logic for SaaS Architecture
        if ($user) {
            if ($user->hasRole('Super Admin')) {
                return redirect()->intended(route('superadmin.dashboard', absolute: false));
            } elseif ($user->hasRole('Company Admin')) {
                return redirect()->intended(route('company.dashboard', absolute: false));
            } elseif ($user->hasRole('Manager') || $user->hasRole('Salesman')) {
                return redirect()->intended(route('branch.dashboard', absolute: false));
            }
        }

        // Fallback: redirect to home page if the user has no recognized role assigned.
        // Avoids RouteNotFoundException — no named 'dashboard' route exists in this project.
        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
