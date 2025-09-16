<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'causer_type', 'causer_id',
        'subject_type', 'subject_id',
        'event', 'description',
        'method', 'url', 'ip', 'user_agent',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}

