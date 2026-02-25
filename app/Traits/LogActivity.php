<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogActivity
{
    public function logActivity($action, $model)
{
    ActivityLog::create([
        'user_id'    => Auth::id(),
        'action'     => $action,
        'model'      => get_class($model),
        'model_id'   => $model->id ?? null,

        'old_values' => $action === 'update' ? json_encode($model->getOriginal()) : null,
        'new_values' => $action === 'update' ? json_encode($model->getAttributes()) : null,

        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
        'url'        => request()->fullUrl(),
        'method'     => request()->method(),
    ]);
}

}
