<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'ip_address', 
        'user_agent',
        'url', 
        'method',
        'old_values',
        'new_values', 
    ];
    public function getDiff(): array
{
    $old = $this->old_values ? json_decode($this->old_values, true) : [];
    $new = $this->new_values ? json_decode($this->new_values, true) : [];

    $diff = [];

    foreach ($new as $key => $value) {
        $oldValue = $old[$key] ?? null;

        if ($oldValue !== $value) {
            $diff[$key] = [
                'old' => $oldValue,
                'new' => $value,
            ];
        }
    }

    return $diff;
}


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
