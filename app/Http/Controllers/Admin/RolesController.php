<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RolesController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
{
    $this->authorize('viewAny', Role::class);

    $query = Role::query();

    // sorting
    if ($request->filled('sort')) {
        $direction = $request->get('direction', 'asc');
        $query->orderBy($request->sort, $direction);
    }

    $roles = $query->paginate(10);

    return view('admin.roles.index', compact('roles'));
}


    public function create()
    {
        $this->authorize('create', Role::class);

        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug',
        ]);

        Role::create($request->only('name', 'slug'));

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully');
    }

    public function edit(Role $role)
{
    $this->authorize('update', $role);

    $permissions = \App\Models\Permission::all();

    return view('admin.roles.edit', compact('role', 'permissions'));
}

    public function update(Request $request, Role $role)
{
    $this->authorize('update', $role);

    $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:roles,slug,' . $role->id,
        'permissions' => 'array',
        'permissions.*' => 'exists:permissions,id',
    ]);

    // Обновляем имя и slug
    $role->update([
        'name' => $request->name,
        'slug' => $request->slug,
    ]);

    // Синхронизируем permissions
    $role->permissions()->sync($request->permissions ?? []);

    return redirect()->route('admin.roles.index')
        ->with('success', 'Role updated successfully');
}


    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        if ($role->slug === 'admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'You cannot delete yourself');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role delete');
    }
}
