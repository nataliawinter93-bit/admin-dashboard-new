<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermissionsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        // Laravel 12 — POST update fix
        Route::post('/users/{user}', [UsersController::class, 'update'])
            ->name('users.update')
            ->middleware('permission:edit_users');

        Route::get('/users', [UsersController::class, 'index'])
            ->name('users.index')
            ->middleware('permission:view_users');

        Route::get('/users/create', [UsersController::class, 'create'])
            ->name('users.create')
            ->middleware('permission:create_users');

        Route::post('/users', [UsersController::class, 'store'])
            ->name('users.store')
            ->middleware('permission:create_users');

        Route::get('/users/{user}/edit', [UsersController::class, 'edit'])
            ->name('users.edit')
            ->middleware('permission:edit_users');

        Route::delete('/users/{user}', [UsersController::class, 'destroy'])
            ->name('users.destroy')
            ->middleware('permission:delete_users');


        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */

        // Laravel 12 — POST update fix
        Route::post('/roles/{role}', [RolesController::class, 'update'])
            ->name('roles.update')
            ->middleware('permission:edit_roles');

        Route::get('/roles', [RolesController::class, 'index'])
            ->name('roles.index')
            ->middleware('permission:view_roles');

        Route::get('/roles/create', [RolesController::class, 'create'])
            ->name('roles.create')
            ->middleware('permission:create_roles');

        Route::post('/roles', [RolesController::class, 'store'])
            ->name('roles.store')
            ->middleware('permission:create_roles');

        Route::get('/roles/{role}/edit', [RolesController::class, 'edit'])
            ->name('roles.edit')
            ->middleware('permission:edit_roles');

        Route::delete('/roles/{role}', [RolesController::class, 'destroy'])
            ->name('roles.destroy')
            ->middleware('permission:delete_roles');


        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */

        // Laravel 12 — POST update fix
        Route::post('/permissions/{permission}', [PermissionsController::class, 'update'])
            ->name('permissions.update')
            ->middleware('permission:edit_permissions');

        Route::get('/permissions', [PermissionsController::class, 'index'])
            ->name('permissions.index')
            ->middleware('permission:view_permissions');

        Route::get('/permissions/create', [PermissionsController::class, 'create'])
            ->name('permissions.create')
            ->middleware('permission:create_permissions');

        Route::post('/permissions', [PermissionsController::class, 'store'])
            ->name('permissions.store')
            ->middleware('permission:create_permissions');

        Route::get('/permissions/{permission}/edit', [PermissionsController::class, 'edit'])
            ->name('permissions.edit')
            ->middleware('permission:edit_permissions');

        Route::delete('/permissions/{permission}', [PermissionsController::class, 'destroy'])
            ->name('permissions.destroy')
            ->middleware('permission:delete_permissions');
    });
