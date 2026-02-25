<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;

class RolePolicy
{
    public function viewAny(User $user)
    {
        return $user->role?->permissions->contains('name', 'view_roles');
    }

    public function create(User $user)
    {
        return $user->role?->permissions->contains('name', 'create_roles');
    }

    public function update(User $user, Role $role)
    {
        return $user->role?->permissions->contains('name', 'edit_roles');
    }

    public function delete(User $user, Role $role)
    {
        return $user->role?->permissions->contains('name', 'delete_roles');
    }
}
