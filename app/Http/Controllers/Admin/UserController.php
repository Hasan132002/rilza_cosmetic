<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles')->latest();

        // Filter by role
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(20);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all()->groupBy(function ($permission) {
            // Group by module (second word after underscore)
            $parts = explode('_', $permission->name);
            return $parts[1] ?? 'other';
        });
        return view('admin.users.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
            'is_active' => ['required', 'boolean'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => $validated['is_active'],
        ]);

        $user->assignRole($validated['role']);

        // Assign additional permissions if provided
        if (!empty($validated['permissions'])) {
            $user->givePermissionTo($validated['permissions']);
        }

        // Log activity
        ActivityLog::log('created', $user, null, $user->toArray(), "Created new user: {$user->name}");

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all()->groupBy(function ($permission) {
            $parts = explode('_', $permission->name);
            return $parts[1] ?? 'other';
        });
        $userPermissions = $user->permissions->pluck('name')->toArray();
        $userRole = $user->roles->first()?->name;

        return view('admin.users.edit', compact('user', 'roles', 'permissions', 'userPermissions', 'userRole'));
    }

    public function update(Request $request, User $user)
    {
        // Prevent modifying super_admin if not super_admin
        if ($user->hasRole('super_admin') && !auth()->user()->hasRole('super_admin')) {
            return back()->with('error', 'You cannot modify super admin users!');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
            'is_active' => ['required', 'boolean'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $oldValues = $user->toArray();

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_active' => $validated['is_active'],
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->syncRoles([$validated['role']]);

        // Sync permissions
        if (isset($validated['permissions'])) {
            $user->syncPermissions($validated['permissions']);
        } else {
            $user->syncPermissions([]);
        }

        // Log activity
        ActivityLog::log('updated', $user, $oldValues, $user->fresh()->toArray(), "Updated user: {$user->name}");

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        // Prevent deleting super admin if not super admin
        if ($user->hasRole('super_admin') && !auth()->user()->hasRole('super_admin')) {
            return back()->with('error', 'You cannot delete a super admin!');
        }

        $userName = $user->name;
        $oldValues = $user->toArray();

        $user->delete();

        // Log activity
        ActivityLog::log('deleted', 'User', $oldValues, null, "Deleted user: {$userName}");

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}
