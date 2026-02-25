<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\LogActivity;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    use AuthorizesRequests;
    use LogActivity;

    public function index(Request $request)
{
    $this->authorize('viewAny', User::class);

    $query = User::with('role');

    // filter role
    if ($request->filled('role_id')) {
        $query->where('role_id', $request->role_id);
    }

    // filter name / email
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }
    // sorting
if ($request->filled('sort')) {
    $direction = $request->get('direction', 'asc');

    if ($request->sort === 'role') {
        $query->leftJoin('roles', 'users.role_id', '=', 'roles.id')
              ->select('users.*')
              ->orderBy('roles.name', $direction);
    } else {
        $query->orderBy($request->sort, $direction);
    }
}




    $users = $query->paginate(10);

    $roles = Role::all();

    return view('admin.users.index', compact('users', 'roles'));
}
public function create()
{
    $this->authorize('create', User::class);

    $roles = Role::all();

    return view('admin.users.create', compact('roles'));
}



public function store(Request $request)
{
    $this->authorize('create', User::class);

    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role_id'  => 'required|exists:roles,id',
    ]);

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => bcrypt($request->password),
        'role_id'  => $request->role_id,
    ]);

    // ЛОГИРУЕМ СОЗДАНИЕ
    $this->logActivity('create', $user);

    return redirect()->route('admin.users.index')
        ->with('success', 'User created successfully');
}


    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
{
    $this->authorize('update', $user);

    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
        'role_id'  => 'required|exists:roles,id',
    ]);

    $data = [
        'name'    => $request->name,
        'email'   => $request->email,
        'role_id' => $request->role_id,
    ];

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $user->update($data);

    $this->logActivity('update', $user);

    return redirect()->route('admin.users.index')
        ->with('success', 'User updated successfully');
}

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if (Auth::id() === $user->id) {
    return back()->with('error', 'You cannot delete yourself');
}

        $user->delete();

        // ЛОГИРУЕМ
        $this->logActivity('delete', $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User delete');
    }
}
