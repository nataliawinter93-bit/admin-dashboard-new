<?php

namespace App\Observers;

use App\Models\User;
use App\Models\ActivityLog;

class ActivityLogObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        ActivityLog::create([
            'user_id'    => auth()->id(),
            'action'     => 'create',
            'model'      => User::class,
            'model_id'   => $user->id,
            'old_values' => null,
            'new_values' => json_encode($user->getAttributes()),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url'        => request()->fullUrl(),
            'method'     => request()->method(),
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        ActivityLog::create([
            'user_id'    => auth()->id(),
            'action'     => 'update',
            'model'      => User::class,
            'model_id'   => $user->id,
            'old_values' => json_encode($user->getOriginal()),
            'new_values' => json_encode($user->getChanges()),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url'        => request()->fullUrl(),
            'method'     => request()->method(),
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
{
    ActivityLog::create([
        'user_id'    => auth()->id(),
        'action'     => 'delete',
        'model'      => User::class,
        'model_id'   => $user->id,
        'old_values' => json_encode($user->getOriginal()),
        'new_values' => null,
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
        'url'        => request()->fullUrl(),
        'method'     => request()->method(),
    ]);
}


    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
