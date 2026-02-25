<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\ActivityLog;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/users', fn() => User::all());
Route::middleware('auth:sanctum')->get('/roles', fn() => Role::all());
Route::middleware('auth:sanctum')->get('/permissions', fn() => Permission::all());
Route::middleware('auth:sanctum')->get('/logs', fn() => ActivityLog::with('user')->latest()->get());

Route::middleware('auth:sanctum')->post('/users', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    return User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);
});

Route::middleware('auth:sanctum')->post('/roles', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:roles,name',
    ]);

    return Role::create(['name' => $validated['name']]);
});

Route::middleware('auth:sanctum')->post('/permissions', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:permissions,name',
    ]);

    return Permission::create(['name' => $validated['name']]);
});
