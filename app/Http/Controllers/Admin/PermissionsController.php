<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PermissionsController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
{
    $this->authorize('viewAny', Permission::class);

    $query = Permission::query();

    // sorting
    if ($request->filled('sort')) {
        $direction = $request->get('direction', 'asc');
        $query->orderBy($request->sort, $direction);
    }

    $permissions = $query->paginate(10);

    return view('admin.permissions.index', compact('permissions'));
}


    public function create()
    {
        $this->authorize('create', Permission::class);

        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);

        $request->validate([
            'name'        => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string|max:255',
        ]);

        Permission::create($request->only('name', 'description'));

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission create sucsessfull');
    }

    public function edit(Permission $permission)
    {
        $this->authorize('update', $permission);

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $this->authorize('update', $permission);

        $request->validate([
            'name'        => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string|max:255',
        ]);

        $permission->update($request->only('name', 'description'));

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission update sucsessfull');
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);

        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission delete');
    }
}
