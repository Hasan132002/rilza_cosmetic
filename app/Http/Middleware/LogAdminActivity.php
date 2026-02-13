<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Symfony\Component\HttpFoundation\Response;

class LogAdminActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log if authenticated and method is not GET
        if (auth()->check() && !in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'])) {
            $this->logActivity($request);
        }

        return $response;
    }

    /**
     * Log the activity.
     */
    protected function logActivity(Request $request): void
    {
        // Skip logging for certain routes
        $skipRoutes = [
            'admin.logout',
            'admin.login',
        ];

        $routeName = $request->route()?->getName();
        if (in_array($routeName, $skipRoutes)) {
            return;
        }

        // Determine action based on route name
        $action = $this->determineAction($request);
        $description = $this->generateDescription($request, $action);

        ActivityLog::log(
            action: $action,
            model: $this->getModelFromRoute($request),
            oldValues: null, // Can be enhanced to capture old values
            newValues: $request->except(['_token', '_method', 'password', 'password_confirmation']),
            description: $description
        );
    }

    /**
     * Determine the action type based on the request.
     */
    protected function determineAction(Request $request): string
    {
        $routeName = $request->route()?->getName();

        if (str_contains($routeName, '.store')) {
            return 'created';
        } elseif (str_contains($routeName, '.update')) {
            return 'updated';
        } elseif (str_contains($routeName, '.destroy')) {
            return 'deleted';
        }

        return match ($request->method()) {
            'POST' => 'created',
            'PUT', 'PATCH' => 'updated',
            'DELETE' => 'deleted',
            default => 'action',
        };
    }

    /**
     * Generate a human-readable description.
     */
    protected function generateDescription(Request $request, string $action): string
    {
        $routeName = $request->route()?->getName();
        $segments = explode('.', $routeName);
        $resource = count($segments) > 1 ? ucfirst($segments[1]) : 'Resource';

        return match ($action) {
            'created' => "Created a new {$resource}",
            'updated' => "Updated {$resource}",
            'deleted' => "Deleted {$resource}",
            default => "Performed an action on {$resource}",
        };
    }

    /**
     * Get the model name from the route.
     */
    protected function getModelFromRoute(Request $request): string
    {
        $routeName = $request->route()?->getName();
        if (!$routeName) {
            return 'Unknown';
        }

        $segments = explode('.', $routeName);
        if (count($segments) > 1) {
            $resource = $segments[1];
            // Convert plural resource names to singular model names
            $modelName = ucfirst(rtrim($resource, 's'));
            return "App\\Models\\{$modelName}";
        }

        return 'Unknown';
    }
}
