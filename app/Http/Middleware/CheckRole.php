<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            // Redirect to admin login if accessing admin routes
            if ($request->is('admin') || $request->is('admin/*')) {
                return redirect()->route('admin.login');
            }
            return redirect()->route('login');
        }

        foreach ($roles as $role) {
            if (auth()->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // If authenticated but doesn't have required role
        if ($request->is('admin') || $request->is('admin/*')) {
            return redirect()->route('admin.login')->with('error', 'You do not have permission to access this area.');
        }

        abort(403, 'Unauthorized access.');
    }
}
