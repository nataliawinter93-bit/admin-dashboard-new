<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->role?->permissions->contains('name', 'view_users');
    }

    public function create(User $user)
    {
        return $user->role?->permissions->contains('name', 'create_users');
    }

    public function update(User $user, User $model)
    {
        return $user->role?->permissions->contains('name', 'edit_users');
    }

    public function delete(User $user, User $model)
    {
        return $user->role?->permissions->contains('name', 'delete_users');
    }
}
