<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('permissions', 'users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            // Group by prefix (e.g., 'view' from 'view_products')
            return explode('_', $permission->name)[0];
        });

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        // Log activity
        ActivityLog::log('created', $role, null, $role->toArray(), "Created new role: {$role->name}");

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully!');
    }

    public function edit(Role $role)
    {
        // Prevent editing super_admin role
        if ($role->name === 'super_admin' && !auth()->user()->hasRole('super_admin')) {
            return back()->with('error', 'You cannot edit the super admin role!');
        }

        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('_', $permission->name)[0];
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        // Prevent editing super_admin role
        if ($role->name === 'super_admin') {
            return back()->with('error', 'You cannot edit the super admin role!');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $oldValues = $role->toArray();

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        // Log activity
        ActivityLog::log('updated', $role, $oldValues, $role->fresh()->toArray(), "Updated role: {$role->name}");

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully!');
    }

    public function destroy(Role $role)
    {
        // Prevent deleting super_admin role
        if ($role->name === 'super_admin') {
            return back()->with('error', 'You cannot delete the super admin role!');
        }

        // Check if role has users
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Cannot delete role with assigned users! Reassign users first.');
        }

        $roleName = $role->name;
        $oldValues = $role->toArray();

        $role->delete();

        // Log activity
        ActivityLog::log('deleted', 'Role', $oldValues, null, "Deleted role: {$roleName}");

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully!');
    }
}
