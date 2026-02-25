<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('api_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => $user,
    ]);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API: список пользователей
Route::middleware('auth:sanctum')->get('/users', function () {
    return User::all();
});

// API: список ролей
Route::middleware('auth:sanctum')->get('/roles', function () {
    return Role::all();
});

// API: список прав
Route::middleware('auth:sanctum')->get('/permissions', function () {
    return Permission::all();
});

// API: список логов
Route::middleware('auth:sanctum')->get('/logs', function () {
    return ActivityLog::with('user')->latest()->get();
});

// API: создать пользователя
Route::middleware('auth:sanctum')->post('/users', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    return response()->json($user, 201);
});

// API: создать роль
Route::middleware('auth:sanctum')->post('/roles', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:roles,name',
    ]);

    $role = Role::create([
        'name' => $validated['name'],
    ]);

    return response()->json($role, 201);
});

// API: создать право
Route::middleware('auth:sanctum')->post('/permissions', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:permissions,name',
    ]);

    $permission = Permission::create([
        'name' => $validated['name'],
    ]);

    return response()->json($permission, 201);
});

// API: logout
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logged out']);
});
