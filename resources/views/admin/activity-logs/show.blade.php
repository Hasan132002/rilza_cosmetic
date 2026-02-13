@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-file-alt text-primary"></i> Activity Log Details
            </h1>
            <p class="text-muted mb-0">ID: #{{ $log->id }}</p>
        </div>
        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Logs
        </a>
    </div>

    <div class="row">
        <!-- Main Info -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Activity Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">User:</th>
                            <td>
                                @if($log->user)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-md bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                            {{ substr($log->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $log->user->name }}</div>
                                            <small class="text-muted">{{ $log->user->email }}</small><br>
                                            <small class="badge bg-info">
                                                {{ $log->user->roles->pluck('name')->join(', ') }}
                                            </small>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Unknown User</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Action:</th>
                            <td>
                                <span class="badge bg-{{ $log->badge_color }} fs-6">
                                    {{ $log->action_name }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Model Type:</th>
                            <td>
                                <span class="badge bg-light text-dark">{{ $log->model_type }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Model ID:</th>
                            <td>{{ $log->model_id ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $log->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Timestamp:</th>
                            <td>
                                {{ $log->created_at->format('F d, Y h:i:s A') }}<br>
                                <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- New Values -->
            @if($log->new_values)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle"></i> New Values
                        </h5>
                    </div>
                    <div class="card-body">
                        <pre class="bg-light p-3 rounded" style="max-height: 400px; overflow-y: auto;">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            @endif

            <!-- Old Values -->
            @if($log->old_values)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-history"></i> Old Values
                        </h5>
                    </div>
                    <div class="card-body">
                        <pre class="bg-light p-3 rounded" style="max-height: 400px; overflow-y: auto;">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- System Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">System Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">IP Address</label>
                        <div class="fw-bold">{{ $log->ip_address ?? 'N/A' }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">User Agent</label>
                        <div class="fw-bold" style="word-break: break-all;">
                            {{ $log->user_agent ?? 'N/A' }}
                        </div>
                    </div>

                    <div>
                        <label class="text-muted small">Log ID</label>
                        <div class="fw-bold">#{{ $log->id }}</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            @if($log->user)
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.activity-logs.index', ['user_id' => $log->user_id]) }}"
                           class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-user"></i> View User's Activities
                        </a>
                        <a href="{{ route('admin.activity-logs.index', ['action' => $log->action]) }}"
                           class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-filter"></i> View Similar Actions
                        </a>
                        <a href="{{ route('admin.activity-logs.index', ['model_type' => $log->model_name]) }}"
                           class="btn btn-outline-primary w-100">
                            <i class="fas fa-database"></i> View Model Activities
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-md {
    width: 50px;
    height: 50px;
    font-size: 1.25rem;
}
</style>
@endsection
