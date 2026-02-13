<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('model_type', 'like', "%{$request->model_type}%");
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', "%{$request->search}%")
                  ->orWhere('model_type', 'like', "%{$request->search}%");
            });
        }

        $logs = $query->paginate(50);

        // Get all users for filter dropdown
        $users = User::role(['super_admin', 'admin', 'staff'])
            ->orderBy('name')
            ->get();

        // Get unique actions
        $actions = ActivityLog::distinct('action')
            ->pluck('action')
            ->sort()
            ->values();

        // Get unique model types
        $modelTypes = ActivityLog::distinct('model_type')
            ->pluck('model_type')
            ->map(fn($type) => class_basename($type))
            ->sort()
            ->values();

        return view('admin.activity-logs.index', compact('logs', 'users', 'actions', 'modelTypes'));
    }

    /**
     * Display the specified activity log.
     */
    public function show(ActivityLog $log)
    {
        $log->load('user');

        return view('admin.activity-logs.show', compact('log'));
    }
}
