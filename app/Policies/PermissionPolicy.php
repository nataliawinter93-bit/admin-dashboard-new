<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Permission;

class PermissionPolicy
{
    public function viewAny(User $user)
    {
        return $user->role?->permissions->contains('name', 'view_permissions');
    }

    public function create(User $user)
    {
        return $user->role?->permissions->contains('name', 'create_permissions');
    }

    public function update(User $user, Permission $permission)
    {
        return $user->role?->permissions->contains('name', 'edit_permissions');
    }

    public function delete(User $user, Permission $permission)
    {
        return $user->role?->permissions->contains('name', 'delete_permissions');
    }
}
