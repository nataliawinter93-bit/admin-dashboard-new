<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 */
class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Role>
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
