<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\RolesController;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\ActivityLog;

/*
|--------------------------------------------------------------------------
| Главная страница
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| 🟦 API-маршруты */

Route::prefix('api')->group(function () {

    Route::get('/test', function () {
        return ['status' => 'API работает!'];
    });

    Route::get('/users', function () {
        return User::all();
    });

    Route::get('/roles', function () {
        return Role::all();
    });

    Route::get('/permissions', function () {
        return Permission::all();
    });

    Route::get('/logs', function () {
        return ActivityLog::with('user')->latest()->get();
    });

    Route::post('/users', function (Request $request) {
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

    Route::post('/roles', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        return Role::create(['name' => $validated['name']]);
    });

    Route::post('/permissions', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        return Permission::create(['name' => $validated['name']]);
    });
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isAdmin'])->group(function () {
    

    // Логи
    Route::get('/admin/logs', [ActivityLogController::class, 'index'])
        ->name('admin.logs.index');
        Route::get('/admin/logs/export', [ActivityLogController::class, 'export'])
    ->name('admin.logs.export');


    Route::get('/admin/logs/{id}', [ActivityLogController::class, 'show']);

    // Пользователи
    Route::get('/admin/users', [\App\Http\Controllers\Admin\UsersController::class, 'index'])
        ->name('admin.users.index');

    Route::get('/admin/users/create', [\App\Http\Controllers\Admin\UsersController::class, 'create'])
        ->name('admin.users.create');

    Route::post('/admin/users', [\App\Http\Controllers\Admin\UsersController::class, 'store'])
        ->name('admin.users.store');

    Route::get('/admin/users/{user}/edit', [\App\Http\Controllers\Admin\UsersController::class, 'edit'])
        ->name('admin.users.edit');

    Route::put('/admin/users/{user}', [\App\Http\Controllers\Admin\UsersController::class, 'update'])
        ->name('admin.users.update');

    Route::delete('/admin/users/{user}', [\App\Http\Controllers\Admin\UsersController::class, 'destroy'])
        ->name('admin.users.destroy');
    // Роли
    Route::get('/admin/roles', [RolesController::class, 'index']) 
    ->name('admin.roles.index'); 
    Route::get('/admin/roles/create', [RolesController::class, 'create'])
     ->name('admin.roles.create'); 
     Route::post('/admin/roles', [RolesController::class, 'store']) 
     ->name('admin.roles.store'); 
     Route::get('/admin/roles/{role}/edit', [RolesController::class, 'edit']) 
     ->name('admin.roles.edit'); 
     Route::put('/admin/roles/{role}', [RolesController::class, 'update']) 
     ->name('admin.roles.update'); 
     Route::delete('/admin/roles/{role}', [RolesController::class, 'destroy']) 
     ->name('admin.roles.destroy');
     Route::get('/admin/analytics', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->name('admin.analytics');
    Route::get('/admin/analytics', [\App\Http\Controllers\Admin\DashboardController::class, 'analytics'])
    ->name('admin.analytics');


     
    });

/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
