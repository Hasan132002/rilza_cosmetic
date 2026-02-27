<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        // If already authenticated as admin, redirect to appropriate dashboard
        if (Auth::check() && $this->isAdmin()) {
            if (Auth::user()->hasRole('super_admin')) {
                return redirect()->route('admin.super.dashboard');
            }
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Attempt authentication
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check if user has admin access
            if ($this->isAdmin()) {
                if (Auth::user()->hasRole('super_admin')) {
                    return redirect()->intended(route('admin.super.dashboard'));
                }
                return redirect()->intended(route('admin.dashboard'));
            }

            // If not admin, logout and show error
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'You do not have permission to access the admin panel.',
            ]);
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle admin logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Check if the current user is an admin.
     */
    protected function isAdmin(): bool
    {
        return Auth::user()->hasAnyRole(['super_admin', 'admin', 'staff']);
    }
}
